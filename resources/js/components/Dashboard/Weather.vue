<template>
    <tile :position="position" modifiers="weather">
        <section class="weather-main">
            <div class="weather-main__icon"><i class="wi" :class="icon" /></div>
            <div class="weather-main__temperature">
                {{ temperature.value }} <span class="weather-main__uom" v-html="temperature.uom" />
            </div>
        </section>
        <section class="weather-details">
            <div class="weather-details__state" v-text="$t('state.' + state)"></div>
            <div class="weather-details__other">
                <span><i class="wi wi-humidity" />{{ humidity.value }}{{ humidity.uom }}</span>
                <span
                    ><i class="wi wi-strong-wind" />{{ windspeed.value }}&nbsp;{{
                        windspeed.uom
                    }}</span
                >
            </div>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { numberFormat } from '../../helpers';
import moment from 'moment-timezone';
import axios from 'axios';
import math from 'mathjs';

export default {
    i18n: {
        messages: {
            'ja-JP': {
                state: {
                    clear: '晴れ',
                    cloudy: '曇り',
                    partly_cloudy: '部分的に曇り',
                    mostly_cloudy: 'ほとんど曇り',
                    overcast: '曇り',
                    drizzle: '霧雨',
                    drizzle_and_breezy: '霧雨と風邪',
                    light_rain: '小雨',
                    breezy_and_partly_cloudy: '部分的に曇りと風邪',
                    breezy_and_cloudy: '曇りと風邪',
                    breezy_and_light_rain: 'なし',
                    unknown: 'なし',
                },
            },
            'en-US': {
                state: {
                    clear: 'Clear',
                    cloudy: 'Cloudy',
                    partly_cloudy: 'Partly Cloudy',
                    mostly_cloudy: 'Mostly Cloudy',
                    overcast: 'Overcast',
                    drizzle: 'Drizzle',
                    drizzle_and_breezy: 'Drizzle and Breezy',
                    light_rain: 'Light Rain',
                    breezy_and_partly_cloudy: 'Breezy and Partly Cloudy',
                    breezy_and_cloudy: 'Breezy and Cloudy',
                    breezy_and_light_rain: 'Breezy and Light Rain',
                    unknown: 'N/A',
                    moderate_rain: 'Moderate Rain',
                    breezy_and_clear: 'Breezy and Clear',
                    breezy_and_moderate_rain: 'Breezy and Moderate Rain',
                    windy_and_moderate_rain: 'Windy and Moderate Rain',
                    fog: 'Fog',
                },
            },
        },
    },

    components: {
        Tile,
    },

    mixins: [saveState],

    props: ['position'],

    data() {
        return {
            state: 'unknown',
            icon: 'wi-na',
            temperature: {
                value: null,
                uom: 'celsius',
            },
            humidity: {
                value: 0,
                uom: '%',
            },
            windspeed: {
                value: 0,
                uom: 'm/s',
            },
        };
    },

    created() {
        // Nudge Volta to fetch the weather
        if (!this.temperature.value) {
            axios.post('/api/dashboard/update/weather');
        }

        this.som =
            typeof window.Volta.preferences.dashboard.weather === 'undefined'
                ? 'metric'
                : window.Volta.preferences.dashboard.weather.system_of_measure;

        this.$root.echo
            .channel('weather.' + window.Volta.city)
            .listen('Weather.WeatherFetched', response => {
                this.temperature.uom = '&degC';
                let temperature = response.weather['temperature']['value'];
                if (this.som === 'imperial') {
                    this.temperature.uom = '&degF';
                    const temp = math.unit(temperature, 'degC');
                    temperature = temp.toNumeric('degF');
                }
                this.temperature.value = numberFormat(temperature, 1);

                this.humidity.value = numberFormat(response.weather['humidity']['value'], 0);
                this.humidity.uom = response.weather['humidity']['uom'];

                this.windspeed.uom = response.weather['windspeed']['uom'];
                let wind_speed = response.weather['windspeed']['value'];
                if (this.som === 'imperial') {
                    this.windspeed.uom = 'm/h';
                    const speed = math.unit(wind_speed, 'meters / second');
                    wind_speed = speed.toNumeric('miles / hour');
                }
                this.windspeed.value = numberFormat(wind_speed, 0);

                this.state = response.weather['state'];
                this.sun = response.weather['sun'];
                this.icon = this.weatherIcon(response.weather['state']);
            });
    },

    methods: {
        numberFormat,

        getSaveStateConfig() {
            return {
                cacheKey: 'weather',
            };
        },

        sunIsAboveHorizon() {
            return moment
                .tz()
                .utc()
                .isBetween(this.sun['rise'], this.sun['set']);
        },

        weatherIcon(state) {
            const iconMappingDayTime = {
                Drizzle: 'wi-sprinkle',
                'Mostly Cloudy': 'wi-cloudy',
                'Partly Cloudy': 'wi-day-cloudy',
                'Light Rain': 'wi-day-sprinkle',
                Rain: 'wi-rain',
                'Rain and Breezy': 'wi-rain-wind',
                'Drizzle and Breezy': 'wi-rain-wind',
                Breezy: 'wi-day-light-wind',

                cloudy: 'wi-cloudy',
                light_rain: 'wi-day-sprinkle',
                moderate_rain: 'wi-day-rain',

                breezy_and_clear: 'wi-day-windy',
                breezy_and_partly_cloudy: 'wi-day-cloudy-windy',
                breezy_and_cloudy: 'wi-day-cloudy-windy',
                breezy_and_light_rain: 'wi-day-rain-wind',
                breezy_and_moderate_rain: 'wi-day-rain-wind',
                windy_and_moderate_rain: 'wi-day-rain-wind',
                windy_and_clear: 'wi-day-windy',

                fog: 'wi-fog',
                clear: 'wi-day-sunny',

                'Breezy and Mostly Cloudy': 'wi-day-cloudy-windy',
                'Windy and Partly Cloudy': 'wi-day-cloudy-gusts',

                Humid: 'wi-hot',
                'Humid and Partly Cloudy': 'wi-day-cloudy',
                'Humid and Mostly Cloudy': 'wi-day-cloudy',
                'Breezy and Humid': 'wi-day-windy',
                Overcast: 'wi-day-sunny-overcast',
                'weather-windy': 'wi-day-windy',
                'weather-cloudy': 'wi-cloudy',
                'weather-pouring': 'wi-rain',
                'weather-partlycloudy': 'wi-day-cloudy',
                'weather-sunny': 'wi-day-sunny',
                unknown: 'wi-na',
            };

            const iconMappingNightTime = {
                Drizzle: 'wi-night-alt-sprinkle',
                'Mostly Cloudy': 'wi-night-cloudy',
                'Partly Cloudy': 'wi-night-partly-cloudy',
                'Light Rain': 'wi-night-alt-sprinkle',
                Rain: 'wi-na',
                'Rain and Breezy': 'wi-night-alt-rain-wind',
                'Drizzle and Breezy': 'wi-night-alt-rain-wind',
                Breezy: 'wi-na',

                cloudy: 'wi-night-cloudy',
                light_rain: 'wi-night-alt-sprinkle',
                moderate_rain: 'wi-night-alt-rain',

                breezy_and_clear: 'wi-windy',
                breezy_and_partly_cloudy: 'wi-night-alt-cloudy-windy',
                breezy_and_cloudy: 'wi-night-alt-cloudy-windy',
                breezy_and_light_rain: 'wi-night-alt-rain-wind',
                breezy_and_moderate_rain: 'wi-night-alt-rain-wind',
                windy_and_moderate_rain: 'wi-night-alt-rain-wind',
                windy_and_clear: 'wi-windy',

                fog: 'wi-night-fog',
                clear: 'wi-night-clear',

                'Breezy and Mostly Cloudy': 'wi-night-alt-cloudy-windy',
                'Windy and Partly Cloudy': 'wi-night-cloudy-windy',

                Humid: 'wi-na',
                'Humid and Partly Cloudy': 'wi-na',
                'Humid and Mostly Cloudy': 'wi-na',
                'Breezy and Humid': 'wi-na',
                Overcast: 'wi-na',
                'weather-windy': 'wi-na',
                'weather-cloudy': 'wi-na',
                'weather-pouring': 'wi-na',
                'weather-partlycloudy': 'wi-na',
                'weather-sunny': 'wi-na',
                unknown: 'wi-na',
            };

            return this.sunIsAboveHorizon() === true
                ? iconMappingDayTime[state]
                : iconMappingNightTime[state];
        },
    },
};
</script>
