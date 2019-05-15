<template>
    <div class="container-fluid git-checker"
         v-bind:style="[success ? { 'border-color': 'green' } : { 'border-color': '$primary' } &&
                 error ? { 'border-color': 'red' } : { 'background': '$primary' }]">
        <div class="row">
            <div class="git-checker-title"
                 v-bind:style="[success ? { 'background-color': 'green' } : { 'background-color': '#007BFF' } &&
                 error ? { 'background-color': 'red' } : { 'background-color': '#007BFF' }]">
                Repository
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="repo"
                       style="padding-top: 20px">Git repository</label>
                <input type="text" class="form-control" name="repository" id="repo"
                       placeholder="https://git.com/user/repository.git" v-model="repo" @change="onChangeRepo()">
                <small class="form-text text-muted">
                    Repository must be public
                </small>
            </div>

            <div class="col-md-6">
                <div v-if="tags_list">
                    <label for="tag" style="padding-top: 20px">Git Tag</label>
                    <select class="form-control" id="tag" v-model="tag">
                        <option v-for="tag in tags_list">{{ tag }}</option>
                    </select>
                    <input type="hidden" class="form-control" name="gitCommit" id="gitCommit" v-model="commit_value">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary"
                        style="float: right; margin-top: 1rem" v-on:click="checkGitRepository()"
                        v-bind:class="{ 'btn-danger': error, 'btn-success': success }" v-if="button_check && !loading">
                    {{ button_text }}
                </button>
            </div>
            <div class="col-md-12" v-if="loading">
                <div class="d-flex align-items-center">
                    <div class="spinner-border spinner-border-md ml-auto text-secondary" role="status"
                         aria-hidden="true"></div>
                </div>
            </div>
            <div class="col-md-12" v-if="error_text">
                <span class="text-danger" style="float: right; margin-top: 1rem">{{ error_text }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tag: null,
                repo: null,
                error: false,
                error_text: null,
                success: false,
                loading: false,
                button_text: 'Check',
                button_check: false,
                commit_value: null,
                tags_list: null,
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {

            onChangeRepo() {
                this.loading = true;

                const url = '/api/git/repo/tags?repo=' + this.repo;
                axios.get(url)
                    .then(response => {
                        this.error = false;
                        this.success = false;
                        this.loading = false;
                        this.button_text = 'Check';
                        this.tags_list = response.data.tags;
                        this.error_text = null;
                        this.commit_value = null;
                        this.button_check = true;
                    })
                    .catch(error => {
                        this.success = false;
                        this.error = true;
                        this.loading = false;
                        this.button_text = 'Check';
                        this.error_text = error.response.data.message;
                        this.commit_value = null;
                        this.tags_list = null;
                        this.button_check = false;
                    });
            },

            checkGitRepository: function () {
                this.loading = true;
                this.button_text = 'Loading...';

                if (this.repo === null || this.tag === null) {
                    this.success = false;
                    this.error = true;
                    this.loading = false;
                    this.button_text = 'Check';
                    this.error_text = 'Seems like one of the input is empty please check again';
                    return;
                }
                const url = '/api/git/repo/check?repo=' + this.repo + '&tag=' + this.tag;

                axios.get(url)
                    .then(response => {
                        this.success = true;
                        this.error = false;
                        this.loading = false;
                        this.button_text = 'Check';
                        this.error_text = null;
                        this.commit_value = response.data;
                    })
                    .catch(error => {
                        this.success = false;
                        this.error = true;
                        this.loading = false;
                        this.button_text = 'Check';
                        this.error_text = error.response.data.message;
                        this.commit_value = null;
                    });
            }
        }
    }
</script>
