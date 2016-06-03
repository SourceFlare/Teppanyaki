#!/bin/bash

# SET ENVIRONMENT
cd /ops/Teppanyaki/
chmod +x teppanyaki-cli.php

# Build UNITARY AUTH AREA LIST and UNITARY AUTH AREA LOCATIONS FILES
./teppanyaki-cli forecast_site_list\unitary_auth_area_list /web/data/forecast_site_list.json
./teppanyaki-cli forecast_site_list\unitary_auth_areas /web/data/forecast_site_list.json

# Build REGION LIST and REGION LOCATION FILES
./php teppanyaki-cli forecast_site_list\region_list /web/data/forecast_site_list.json
./php teppanyaki-cli forecast_site_list\regions /web/data/forecast_site_list.json

# Build FIVE DAY FORECAST FILES and SIMPLIFIED FILES
./php teppanyaki-cli five_day_forecast\five_day_summarised_forecast_all_sites_all_timesteps /web/data/five_day_summarised_forecast_all_sites_all_timesteps.json
./php teppanyaki-cli five_day_forecast\five_day_summarised_forecast_all_sites_all_timesteps_simplified /web/data/five_day_summarised_forecast_all_sites_all_timesteps.json

# Build THREE-HOURLY FORECAST FILES FOR EACH LOCATION
./php teppanyaki-cli three_hour_forecast\three_hour_forecast_all_sites_all_timesteps /web/data/.json

# Build HOURLY OBSERVATIONS
./php teppanyaki-cli hourly_observations\hourly_site_observations_all_sites_all_timestamps /web/data/forecast_site_list.json
