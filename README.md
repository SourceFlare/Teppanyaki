# Teppanyaki
Teppanyaki is a Recipe Dispatcher written in PHP that will run primarily on the command line, but can also integrate into PHP web stacks.

It offers a bare-bones environment to slice 'n' dice data, then output it into useful formats... you write the recipe, the cook does the work!

### Provided Examples

    1. 5 Day Forecast Location Data
    2. 3-Hourly Forecast Location Date
    3. Hourly Observations (Near-Real-Time)

All three of these take the main all-in-one API files from MetOffice Datapoint, and transpile them into JSON files for each of the 5,000+ UK locations.

### Other use cases
You could use Teppanyaki to log actions from your system or web stack, process emails, package files, light database operations, etc.

# Installation

    wget https://github.com/SourceFlare/Teppanyaki/archive/master.zip
    unzip master.zip
    chmod +x teppanyaki-cli.php

# Usage

    teppanyaki-cli five_day_forecast\five_day_summarised_forecast_all_sites_all_timesteps ./data/five_day_forecast.json

### What does this mean?
In Teppnayaki it needs the BOOK, PAGE, and the INGREDIENTS. Here's the deifnition of what these are:

    teppanyaki-cli BOOK\PAGE INGREDIENTS

    BOOK        == Recipe Class
    PAGE        == Recipe Method
    INGREDIENTS == Data

That's it. It's that simple.
