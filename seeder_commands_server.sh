#!/bin/bash

declare -a seeders=(
    "DepartmentSeeder"
    "MunicipalitySeeder"
    "ProgrammeSeeder"
    "ProjectStageTypeSeeder"
    "ProvinceSeeder"
    "StatusTypeSeeder"
    "UserActivityTypeSeeder"
    "SectorSeeder"
    "ProjectActivityTypeSeeder"
)

for seeder in "${seeders[@]}"; do
    echo "Seeding: ${seeder}"
    php artisan db:seed --class "${seeder}"
done
