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
    "AdministratorSeeder"
)

for seeder in "${seeders[@]}"; do
    echo "Seeding: ${seeder}"
    php artisan db:seed --class "${seeder}"
done
