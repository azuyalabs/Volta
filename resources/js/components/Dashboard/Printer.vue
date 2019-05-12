<template>
    <tile :position="position" modifiers="printer" :id="id">
        <section class="printer-header">
            <div class="printer-header_name">
                {{ printerURL[0] }}<span v-if="printerURL[1]">@</span
                ><a
                    :title="$t('open_octoprint')"
                    v-text="printerURL[1]"
                    :href="'http://' + printerURL[1]"
                    target="_blank"
                ></a>
            </div>
        </section>

        <section class="printer-main" v-if="isRunning || jobCompleted">
            <div class="printer-main-printjob-wrap">
                <div class="printer-main-printjob">
                    <div class="printer-main-printjob_text" v-text="printer.printjob.filename" />
                </div>
            </div>
            <div class="printer-main-progress">
                <vm-progress
                    type="circle"
                    :percentage="printer.printjob.progress"
                    :stroke-width="15"
                />
                <div class="printer-main-progress-job" v-if="isRunning">
                    <span class="printer-main-progress-job_title">ETA</span>
                    <span
                        class="printer-main-progress-job_time"
                        v-text="formatETA(printer.printjob.time_remaining)"
                        v-if="printer.printjob.time_remaining !== 0"
                    />
                    <span class="printer-main-progress-job_time" v-else>-</span>
                    <span
                        class="printer-main-progress-job_remaining"
                        v-text="formatPrintJobDuration(printer.printjob.time_remaining)"
                    />
                    <span class="printer-main-progress-status" v-text="printer.state" />
                </div>

                <div class="printer-main-progress-job" v-if="jobCompleted">
                    <span class="printer-main-progress-job_title">Finished</span>
                    <span
                        class="printer-main-progress-job_time"
                        v-text="formatPrintJobDuration(printer.printjob.time_elapsed)"
                    />
                    <span class="printer-main-progress-usage"
                        >Filament:
                        {{ numberFormat(printer.printjob.filament_length / 1000) }}m</span
                    >
                </div>
            </div>
        </section>

        <section class="printer-main content-center" v-else-if="!isOffline">
            <span>{{ $t('printer_states.ready') }}</span>
        </section>
        <section class="printer-main content-center" v-else>
            {{ $t('printer_states.offline') }}
        </section>
        <section class="printer-footer" v-if="isRunning">
            <span>
                <svgicon icon="printer-heatbed" class="printer-footer-icon" />
                {{ printer.heatbed_temperature.current }}&deg;C
            </span>
            <span>
                <svgicon icon="printer-extruder" class="printer-footer-icon" />
                {{ printer.extruder_temperature.current }}&deg;C
            </span>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import clearSavedState from 'vue-save-state';
import { formatETA, formatPrintJobDuration, numberFormat } from '../../helpers.js';

import '../../../svg-icons/compiled/printer-extruder.js';
import '../../../svg-icons/compiled/printer-heatbed.js';

export default {
    i18n: {
        messages: {
            'en-US': {
                printer_states: {
                    ready: 'Ready',
                    offline: 'Offline',
                },
                open_octoprint: 'Open the OctoPrint instance of this printer in a new window/tab',
            },
        },
    },

    components: {
        Tile,
    },

    mixins: [saveState, clearSavedState],

    props: {
        id: {
            type: String,
            required: true,
        },
        position: {
            type: String,
        },
    },

    computed: {
        isOffline() {
            return this.printer.state === 'offline';
        },

        isRunning() {
            return ['printing', 'paused', 'pausing', 'resuming'].includes(this.printer.state);
        },

        jobCompleted() {
            return ['finishing', 'finished'].includes(this.printer.state);
        },

        printerURL() {
            return this.printer.printer.split('@');
        },
    },

    data() {
        return {
            printer: {
                progress: 0,
                name: 'N/A',
                printer: 'N/A',
                heatbed_temperature: {
                    current: 0,
                    target: 0,
                },
                extruder_temperature: {
                    current: 0,
                    target: 0,
                },
                time_remaining: 0,
                state: 'offline',
            },
            lastUpdated: 0,
        };
    },

    created() {
        setInterval(this.checkFreshness, 60 * 1000);

        this.$root.echo
            .channel(`printer.${this.id}`)
            .listen('PrinterMonitor.PrinterStatusFetched', response => {
                this.printer = response.status;
                this.lastUpdated = Date.now();
            });
    },

    methods: {
        formatETA,
        formatPrintJobDuration,
        numberFormat,

        getSaveStateConfig() {
            return {
                cacheKey: `printer.${this.id}`,
            };
        },

        checkFreshness() {
            let delta = (Date.now() - this.lastUpdated) / 1000;
            if (delta >= 5 * 3600 && this.isRunning) {
                this.clearSavedState();
            }
        },
    },
};
</script>
