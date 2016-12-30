<template>
    <grid :position="grid">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ count }}</h3>
                <p>Forum Post Count</p>
            </div>
            <div class="icon">
                <i class="fa fa-comment"></i>
            </div>
        </div>
    </grid>
</template>

<script>
import Grid from '../../../../Admin/Resources/dashboard/js/mixins/grid.js';
import API from '../../../../Admin/Resources/dashboard/js/mixins/api.js';

export default {
    name: 'forum-post-count',
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
            this.api('get', '/api/widget/forum/post-count', {}).then((response) => {
                this.count = response.body.data.post_count || 0;
            }, (response) => {
                console.log(['failed', response]);
            });
        },
    }
};
</script>

