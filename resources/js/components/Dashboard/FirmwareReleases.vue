<template>
    <tile :position="position">
        <section>
            <h1 v-text="$t('title')" />
            <ul v-if="firmware_releases.length > 0">
                <li v-for="firmware in firmware_releases" class="firmware__release">
                    <span
                        v-text="firmware.name + ' ' + firmware.version"
                        class="firmware__release-version"
                    />
                    <span class="pill-new" v-if="isNew(firmware.release_date)" v-text="$t('new')" />
                    <span
                        v-else
                        v-text="diffForHumans(firmware.release_date)"
                        class="firmware__release-date"
                    />
                </li>
            </ul>
            <div v-else class="content-center"><span v-text="$t('no_releases')" /></div>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { diffForHumans, isNew } from '../../helpers';
import axios from 'axios';

export default {
    i18n: {
        messages: {
            'en-US': {
                title: 'Firmware Releases',
                no_releases: 'No releases discovered (yet)',
                new: 'New',
            },
        },
    },

    props: ['position'],

    components: {
        Tile,
    },

    mixins: [saveState],

    data() {
        return {
            firmware_releases: [],
        };
    },

    created() {
        // Nudge Volta to fetch the firmware releases
        if (_.isEmpty(this.firmware_releases)) {
            axios.post('/api/dashboard/update/firmwares');
        }

        this.$root.echo
            .channel('firmware_releases')
            .listen('FirmwareReleases.FirmwareReleasesFetched', response => {
                this.firmware_releases = response.firmware_releases;
            });
    },

    methods: {
        diffForHumans,
        isNew,

        getSaveStateConfig() {
            return {
                cacheKey: 'firmware-releases',
            };
        },
    },
};
</script>
