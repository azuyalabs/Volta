<template>
    <tile :position="position" modifiers="clock">
        <section class="clock-main">
            <div class="clock-main__timezone">{{ $t('message.' + this.timeZone) }}</div>
            <div class="clock-main__clock" v-if="type === 'analog'">
                <svg
                    :height="diameter"
                    viewBox="0 0 150 150"
                    version="1.2"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle class="clock__face" r="55" :cx="radius" :cy="radius"></circle>
                    <line
                        class="clock__hand-hour"
                        :x1="radius"
                        :y1="radius + 8"
                        :x2="radius"
                        :y2="radius - 18"
                        :transform="'rotate(' + hour + ',' + radius + ',' + radius + ')'"
                    ></line>
                    <line
                        class="clock__hand-minute"
                        :x1="radius"
                        :y1="radius + 8"
                        :x2="radius"
                        :y2="radius - 30"
                        :transform="'rotate(' + minute + ',' + radius + ',' + radius + ')'"
                    ></line>
                    <line
                        class="clock__hand-second"
                        :x1="radius"
                        :y1="radius + 12"
                        :x2="radius"
                        :y2="radius - 35"
                        :transform="'rotate(' + seconds + ',' + radius + ',' + radius + ')'"
                    ></line>
                    <circle
                        class="clock__hand-second-center"
                        r="5"
                        :cx="radius"
                        :cy="radius"
                    ></circle>

                    <g id="hour_ticks" class="clock__face-ticks">
                        <template v-for="h of 12">
                            <line
                                :x1="75"
                                :y1="radius - 46"
                                :x2="radius"
                                :y2="radius - 42"
                                :transform="'rotate(' + h * 30 + ',' + radius + ',' + radius + ')'"
                            ></line>
                        </template>
                    </g>
                </svg>
            </div>

            <div class="clock-main__clock clock-main__clock--digital" v-if="type === 'digital'">
                {{ time.format('LT') }}
            </div>
        </section>
        <section class="clock-date" v-text="time.format(dateFormat)" />
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import moment from 'moment-timezone';

export default {
    i18n: {
        messages: {
            'ja-JP': {
                message: {
                    'Asia/Tokyo': '東京',
                    'Europe/Amsterdam': 'ヨーロッパ/アムステルダム',
                    'Europe/Rome': 'ヨーロッパ/ローマ',
                    'America/New_York': 'アメリカ/ニューヨーク',
                    'America/Chicago': 'アメリカ/シカゴ',
                },
            },
            'en-US': {
                message: {
                    'Asia/Tokyo': 'Asia/Tokyo',
                    'Europe/Amsterdam': 'Europe/Amsterdam',
                    'Europe/Rome': 'Europe/Rome',
                    'America/New_York': 'America/New York',
                    'America/Chicago': 'America/Chicago',
                },
            },
        },
    },

    components: {
        Tile,
    },

    props: {
        position: {
            type: String,
        },
        dateFormat: {
            type: String,
            required: false,
            default: 'LL',
        },
    },

    data() {
        return {
            time: '',
            diameter: 150,
            type: 'analog',
        };
    },

    computed: {
        radius() {
            return this.diameter / 2;
        },

        hour() {
            return 30 * ((this.time.hours() % 12) + this.time.minutes() / 60);
        },

        minute() {
            return this.time.minutes() * 6;
        },

        seconds() {
            return this.time.seconds() * 6;
        },
    },

    created() {
        this.type = window.Volta.preferences.dashboard.clock.type;
        this.timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        this.refreshTime();
        setInterval(this.refreshTime, 1000);
    },

    methods: {
        refreshTime() {
            this.time = moment.tz(this.timeZone).locale(window.Volta.locale);
        },

        hourTick(hour) {
            return 'rotate(' + hour * 30 + ',' + this.radius + ',' + this.radius + ')';
        },
    },
};
</script>
