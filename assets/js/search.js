
new Vue({
    el: '#search',
    data: {
        search: '',
        movies: [],
        info: {}
    },
    computed: {
        searchInfo: function() {
            return this.info.hits + ' Filme gefunden';
        }
    },
    methods: {
        onSearch: function() {
            this.index.search(this.search, function(error, result) {
                this.movies = result.hits;
                this.info = {
                    hits: result.nbHits,
                    time: result.processingTimeMS
                };
            }.bind(this));
        }
    },
    created: function() {
        var client = algoliasearch(FFTE.applicationId, FFTE.searchApiKey);
        this.index = client.initIndex('ffte_movies_movies_' + FFTE.environment);
        this.onSearch();
    }
});