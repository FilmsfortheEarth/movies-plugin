
new Vue({
    el: '#search',
    data: {
        search: '',
        result: {},
        movies: [],
        page: 0
    },
    computed: {
        searchInfo: function() {
            return this.info.hits + ' Filme gefunden';
        }
    },
    methods: {
        onSearch: function() {
            this.index.search(this.search, { page: this.page }, function(error, result) {
                this.result = result;
                this.movies.push.apply(this.movies, this.result.hits);
                console.log(result);
            }.bind(this));
        },
        loadMore: function() {
            this.page = this.result.page + 1;
            this.onSearch();
        }
    },
    created: function() {
        var client = algoliasearch(FFTE.applicationId, FFTE.searchApiKey);
        this.index = client.initIndex('ffte_movies_movies_' + FFTE.environment);
        this.onSearch();
    }
});