<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectActivity;
use Carbon\Carbon;
use InvalidArgumentException;

class ProjectRiskService
{
    protected ?Project $project;
    protected ?ProjectActivity $activity;
    protected $project_or_activity;

    public function __construct(Project $project = null, ProjectActivity $activity = null)
    {
        $this->project = $project;
        $this->activity = $activity;

        if (is_null($this->project) && is_null($this->activity)) {
            throw new InvalidArgumentException('Either a Project or ProjectActivity must be provided.');
        }

        $this->setProjectOrActivity();
    }

    public function setProjectOrActivity(): void
    {
        $this->project_or_activity = $this->project ?? $this->activity;
    }

    public function calculateBudgetRisk(): int
    {
        $variance = $this->project_or_activity->budget - $this->project_or_activity->spend;
        $budgetPercentage = ($variance / $this->project_or_activity->budget);

        if ($budgetPercentage < 0.2) {
            return 1; // Low risk
        } elseif ($budgetPercentage > 1) {
            return 3; // High risk
        } else {
            return 2; // Medium risk
        }
    }

    public function calculateScheduleRisk(): int
    {
        // Check if we are using a Project and if the activity is null
        if ($this->project && is_null($this->project->project_activity) || !is_null($this->activity)) {

            // Convert start_date and end_date to Carbon instances
            $startDate = Carbon::parse($this->project_or_activity->start_date);
            $endDate = Carbon::parse($this->project_or_activity->end_date);
            $totalDuration = $endDate->diffInDays($startDate);

            // Calculate the remaining time until the end date
            $remainingTime = $endDate->diffInDays(Carbon::now());

            // Determine the percentage of the remaining time compared to the total duration
            $timePercentage = $remainingTime / $totalDuration;

            // Categorize the risk based on the remaining time
            if ($timePercentage < 0.25) {
                return 1; // Low risk
            } elseif ($timePercentage >= 0.25 && $timePercentage < 0.5) {
                return 2; // Medium risk
            } else {
                return 3; // High risk
            }
        }

        // If there are project activities, delegate risk calculation to another method
        if (!is_null($this->project)) {
            if($this->project->project_activity()->exists()){
                return $this->calculateActivityRisk($this->project->project_activity);
            }
        }
        return 0; // Default or fallback risk level if conditions aren't met
    }

    public function calculateActivityRisk($activities): int
    {
        $activityRisks = [];

        foreach ($activities as $activity) {

            //dd($activity);
            // Get the last progress record's percentage completion
            $lastProgress = $activity->progress()->latest()->first();

            if ($lastProgress) {
                $percentageCompletion = $lastProgress->percentage_completion;

                // Calculate the risk for this activity
                $activityRisk = $this->calculateSingleActivityRisk($percentageCompletion, $activity);
                $activityRisks[] = $activityRisk;
            }
        }

        // Calculate the average risk score across all activities
        if (count($activityRisks) > 0) {
            return array_sum($activityRisks) / count($activityRisks);
        }

        return 0; // Fallback risk if no activities have progress
    }

    protected function calculateSingleActivityRisk(int $percentageCompletion, $activity): int
    {
        // Implement your specific logic to calculate risk based on percentage completion
        if ($percentageCompletion < 25) {
            return 3; // High risk
        } elseif ($percentageCompletion < 50) {
            return 2; // Medium risk
        } else {
            return 1; // Low risk
        }
    }

    public function calculateProcurementRisk(): int
    {
        // Check the procurement status ID and return the associated risk level
        switch ($this->project_or_activity->procurement_status_id) {
            case 12: // Yes
                return 1; // Low risk
            case 13: // No
                return 3; // High risk
            case 14: // Procurement in Progress
                return 2; // Medium risk
            case 15: // NA
            default:
                return 0; // No applicable risk or default risk level
        }
    }


    public function calculateRisk(): int|float
    {
        // Combine or handle the risks as necessary
        // For example, you might average them or weigh them differently

        // OverAll Risk Based on median
        $numbers = [$this->calculateScheduleRisk(),$this->calculateProcurementRisk(),$this->calculateBudgetRisk()];
        sort($numbers);
        $count = count($numbers);
        $middle = floor(($count - 1) / 2);

        if ($count % 2) {
            return $numbers[$middle];
        } else {
            return ($numbers[$middle] + $numbers[$middle + 1]) / 2;
        }

    }




}
