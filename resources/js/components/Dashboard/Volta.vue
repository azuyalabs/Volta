<template>
    <tile :position="position" modifiers="volta"></tile>
</template>

<script>
import Tile from './atoms/Tile';

export default {
    components: {
        Tile,
    },

    props: ['position'],
};
</script>
