<template>
    <b-container fluid class="container">
        <!-- Title/Header -->
        <div class="d-flex">
            <div>
                <h1 class="display-5 text-uppercase">Cost Estimator</h1>
                <h3 class="display-5 text-capitalize">3D Print Job `{{ printJob.name }}`</h3>
            </div>
        </div>

        <p class="text-muted mt-2" style="font-size: medium">
            Use this Cost Estimator to quickly see how much a 3D Print Job will cost. The estimated
            cost is based on the consumed material and used machine. Simply select a filament spools
            and machine for this print job and the cost will be calculated instantly.
        </p>

        <!-- User Input Filters -->
        <div class="form-row">
            <b-form-group label="3D Printer" label-for="input_machine">
                <b-form-select
                    class="col-md-12"
                    id="input_machine"
                    v-model="machine"
                    :plain="false"
                    :options="machines"
                    v-on:change="updateMachine"
                >
                </b-form-select>
            </b-form-group>
            <b-form-group class="ml-3" label="Filament Spool" label-for="input_filamentspool">
                <b-form-select
                    class="col-md-12"
                    id="input_filamentspool"
                    v-model="filamentSpool"
                    :plain="false"
                    :options="filamentSpools"
                    v-on:change="updateFilament"
                >
                </b-form-select>
            </b-form-group>
        </div>

        <!-- Cost Overview -->
        <div class="card-deck mt-3">
            <div class="card-volta card">
                <div class="card-header">Cost Overview</div>
                <div class="card-body" v-if="filamentSpool">
                    <p class="text-muted" style="font-size: small;text-transform: uppercase">
                        Estimated Print Time: {{ estimatedPrintTime }}
                    </p>

                    <!-- Filament Cost -->
                    <div class="row mb-3">
                        <div class="col-sm-1">
                            <b-link
                                @click.stop="filamentDetails = !filamentDetails"
                                title="View more details"
                            >
                                <svgicon
                                    icon="details"
                                    class="action-icon-sm"
                                    :class="{ 'svg-right': filamentDetails }"
                                ></svgicon>
                            </b-link>
                        </div>
                        <div class="col-sm-7"><strong>Filament</strong></div>
                        <div class="col-sm-2 text-right">{{ moneyFormat(filamentCost) }}</div>
                    </div>
                    <div class="row mb-3 container" v-show="filamentDetails">
                        <div class="row ml-3">
                            <div class="col text-muted">
                                {{ numberFormat(this.printJob.filamentInLength / 1000) }} m of
                                <svg height="20" width="20">
                                    <circle
                                        cx="10"
                                        cy="10"
                                        r="10"
                                        :fill="filamentSpool.color_value"
                                    ></circle>
                                </svg>
                                <span
                                    >{{ filamentSpool.manufacturer }} {{ filamentSpool.name }}
                                    <span style="text-transform: uppercase">{{
                                        filamentSpool.material
                                    }}</span>
                                </span>
                                (at a rate of &#126;
                                {{ moneyFormat(filamentSpool.unitPrice.length) }} p/m)
                            </div>
                        </div>
                        <div class="row ml-3">
                            <div class="col text-muted">
                                ({{ numberFormat(this.printJob.filamentInLength / 1000) }} m &#61;
                                {{ numberFormat(usedFilamentInVolume) }} cm<sup>3</sup> &#61;
                                {{ numberFormat(usedFilamentInWeight) }} g)
                            </div>
                        </div>
                    </div>

                    <!-- Electricity Cost -->
                    <div class="row mb-3">
                        <div class="col-sm-1">
                            <b-link
                                @click.stop="electricityDetails = !electricityDetails"
                                title="View more details"
                            >
                                <svgicon
                                    icon="details"
                                    class="action-icon-sm"
                                    :class="{ 'svg-right': electricityDetails }"
                                ></svgicon>
                            </b-link>
                        </div>
                        <div class="col-sm-7"><strong>Electricity</strong></div>
                        <div class="col-sm-2 text-right">{{ moneyFormat(electricityCost) }}</div>
                    </div>
                    <div class="row mb-3 container" v-show="electricityDetails">
                        <div class="row ml-3">
                            <div class="col text-muted">
                                {{ numberFormat(powerConsumption, 4) }} kWh (at a rate of &#126; ¥27
                                p/kWh)
                            </div>
                        </div>
                    </div>

                    <!-- Machine Cost -->
                    <div class="row mb-3">
                        <div class="col-sm-1">
                            <b-link
                                @click.stop="machineDetails = !machineDetails"
                                title="View more details"
                            >
                                <svgicon
                                    icon="details"
                                    class="action-icon-sm"
                                    :class="{ 'svg-right': machineDetails }"
                                ></svgicon>
                            </b-link>
                        </div>
                        <div class="col-sm-7"><strong>Machine</strong></div>
                        <div class="col-sm-2 text-right">{{ moneyFormat(machineCost) }}</div>
                    </div>
                    <div class="row mb-3 container" v-show="machineDetails">
                        <div class="row ml-3">
                            <div class="col text-muted">
                                At a rate of &#126; {{ moneyFormat(machine.hourlyRate) }} p/h
                            </div>
                        </div>
                    </div>

                    <!-- Total Cost -->
                    <div class="row">
                        <div class="col-sm-1 pt-3" />
                        <div class="col-sm-7 pt-3" style="border-top: 1px solid #f00">
                            <strong>Total</strong>
                        </div>
                        <div class="col-sm-2 pt-3 text-right" style="border-top: 1px solid #f00">
                            {{ moneyFormat(totalCost) }}
                        </div>
                    </div>

                    <!-- Visual Cost Breakdown -->
                    <b-progress show-value :max="totalCost" height="2rem" class="mb-3 mt-3">
                        <b-progress-bar variant="success" :value="filamentCost"></b-progress-bar>
                        <b-progress-bar variant="warning" :value="electricityCost"></b-progress-bar>
                        <b-progress-bar variant="info" :value="machineCost"></b-progress-bar>
                    </b-progress>

                    <!-- Cost Breakdown Legend -->
                    <div class="row mb-3">
                        <div class="col-4">
                            <svg height="20" width="20">
                                <circle cx="10" cy="10" r="10" fill="#28a745"></circle>
                            </svg>
                            <span
                                class="text-muted"
                                style="font-size: small;text-transform: uppercase"
                                >Filament</span
                            >
                        </div>
                        <div class="col-4">
                            <svg height="20" width="20">
                                <circle cx="10" cy="10" r="10" fill="#ffc107"></circle>
                            </svg>
                            <span
                                class="text-muted"
                                style="font-size: small;text-transform: uppercase"
                                >Electricity</span
                            >
                        </div>
                        <div class="col-4">
                            <svg height="20" width="20">
                                <circle cx="10" cy="10" r="10" fill="#17a2b8"></circle>
                            </svg>
                            <span
                                class="text-muted"
                                style="font-size: small;text-transform: uppercase"
                                >Machine</span
                            >
                        </div>
                    </div>

                    <p class="text-muted" style="font-size: small;text-transform: uppercase">
                        The cost per hour for this print job would equate to
                        <strong>{{ moneyFormat(costPerHour) }}</strong
                        >.
                    </p>
                </div>
            </div>

            <!-- Slicer Configuration -->
            <div class="card-volta card">
                <div class="card-header-custom card-header">Slicer Configuration</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Sliced with</th>
                                    <td>{{ printJob.slicer }}</td>
                                </tr>
                                <tr>
                                    <th>Layer Height</th>
                                    <td>{{ numberFormat(printJob.layerHeight) }} mm</td>
                                </tr>
                                <tr>
                                    <th>Bed Temperature</th>
                                    <td>{{ numberFormat(printJob.bedTemperature) }} °C</td>
                                </tr>
                                <tr>
                                    <th>Hot End Temperature</th>
                                    <td>{{ numberFormat(printJob.hotendTemperature) }} °C</td>
                                </tr>
                                <tr>
                                    <th>Fill Density</th>
                                    <td>{{ numberFormat(printJob.fillDensity) }} %</td>
                                </tr>
                                <tr>
                                    <th>Perimeter Speed</th>
                                    <td>{{ numberFormat(printJob.perimeterSpeed) }} mm/s</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </b-container>
</template>

<script>
import { durationFormat, moneyFormat, numberFormat } from '../helpers';

export default {
    props: ['filename'],

    data() {
        return {
            printJob: {
                name: '',
            },
            filamentDensity: 0,
            filamentDiameter: 0,
            filamentSpool: null,
            machine: {
                hourlyRate: null,
                energy_consumption: null,
            },
            filamentSpools: [],
            machines: [],
            filamentDetails: false,
            machineDetails: false,
            electricityDetails: false,
        };
    },

    computed: {
        usedFilamentInVolume: function() {
            return (
                (Math.PI *
                    Math.pow(this.filamentDiameter / 2, 2) *
                    this.printJob.filamentInLength) /
                1000
            );
        },

        usedFilamentInWeight: function() {
            return this.usedFilamentInVolume * this.filamentDensity;
        },

        powerConsumption: function() {
            if (typeof this.machine === 'undefined' || !this.machine) {
                return;
            }

            return (
                ((this.printJob.estimatedPrintingTime / 3600) * this.machine.energy_consumption) /
                1000
            );
        },

        estimatedPrintTime: function() {
            return durationFormat(this.printJob.estimatedPrintingTime);
        },

        filamentCost: function() {
            return (
                this.usedFilamentInWeight *
                (this.filamentSpool.purchasePrice / this.filamentSpool.weight)
            );
        },

        machineCost: function() {
            if (typeof this.machine === 'undefined' || !this.machine) {
                return;
            }

            return (this.printJob.estimatedPrintingTime / 3600) * this.machine.hourlyRate;
        },

        electricityCost: function() {
            return this.powerConsumption * 27;
        },

        totalCost: function() {
            return this.filamentCost + this.electricityCost + this.machineCost;
        },

        costPerHour: function() {
            return (this.totalCost / this.printJob.estimatedPrintingTime) * 3600;
        },
    },

    methods: {
        updateFilament: function(filamentSpool) {
            this.filamentDensity = filamentSpool.density;
            this.filamentDiameter = filamentSpool.diameter;
        },

        updateMachine: function(machine) {},

        numberFormat,
        moneyFormat,
    },

    mounted() {
        // Retrieve the Print Job data
        window.axios.get('/api/printjobs/' + this.filename).then(response => {
            if (response.status >= 200 && response.status <= 299) {
                this.printJob = response.data.attributes;
                this.filamentDensity = this.printJob.filamentDensity;
                this.filamentDiameter = this.printJob.filamentDiameter;
            }
        });

        // Populate the Filament Spools Dropdown
        window.axios.get('/api/filamentspools').then(response => {
            if (response.status >= 200 && response.status <= 299) {
                const spools = response.data.data;
                spools.forEach(spools => {
                    this.filamentSpools.push({
                        value: spool.attributes,
                        text: spool.attributes.manufacturer + ' ' + spool.attributes.name,
                    });
                });
            }
        });

        // Populate the Machines Dropdown
        window.axios.get('/api/machines').then(response => {
            if (response.status >= 200 && response.status <= 299) {
                const machines = response.data.data;
                machines.forEach(machine => {
                    this.machines.push({
                        value: machine.attributes,
                        text: machine.attributes.name + ' (' + machine.attributes.model + ')',
                    });
                });
            }
        });
    },
};
</script>
