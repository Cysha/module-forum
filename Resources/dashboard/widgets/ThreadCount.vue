<template>
    <grid :position="grid">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ count }}</h3>
                <p>Forum Thread Count</p>
            </div>
            <div class="icon">
                <i class="fa fa-comments"></i>
            </div>
        </div>
    </grid>
</template>

<script>
import Grid from '../../../../Admin/Resources/dashboard/js/mixins/grid.js';
import API from '../../../../Admin/Resources/dashboard/js/mixins/api.js';

export default {
    name: 'forum-thread-count',
    components: {
        Grid
    },
    mixins: [API],
    props: ['grid'],

    data() {
        return {
            count: 0
        };
    },

    created() {
        this.getCount();
    },

    methods: {
        getCount() {
            this.api('get', '/api/widget/forum/thread-count', {}).then((response) => {
                this.count = response.body.data.thread_count || 0;
            }, (response) => {
                console.log(['failed', response]);
            });
        },
    }
};
</script>

