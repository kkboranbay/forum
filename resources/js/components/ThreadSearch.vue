<template>

    <ais-instant-search
            :search-client="searchClient"
            index-name="threads"
            :routing="routing"
            >

        <div class="row justify-content-center">
            <div class="col-md-8">
                <ais-hits>
                    <div slot="item" slot-scope="{ item }">
                        <a :href="item.path"><ais-highlight :hit="item" attribute="title" /></a>
                    </div>
                </ais-hits>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Search threads
                    </div>

                    <div class="card-body">
                        <ais-search-box>
                            <div slot-scope="{ currentRefinement, isSearchStalled, refine }">
                                <input
                                        type="search"
                                        v-model="currentRefinement"
                                        @input="refine($event.currentTarget.value)"
                                        class="form-control"
                                        placeholder="Search threads ..."
                                        autofocus
                                >
                                <span :hidden="!isSearchStalled">Loading...</span>
                            </div>
                        </ais-search-box>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Filter by channel
                    </div>

                    <div class="card-body">
                        <ais-refinement-list attribute="channel.name" />
                    </div>
                </div>

                <div class="card" v-if="hasTrendingThreads">
                    <div class="card-header">
                        Trending threads
                    </div>

                    <div class="card-body">
                        <li v-for="trending in this.trending" class="list-group-item">
                            <a
                                    :href="trending.path"
                                    v-text="trending.title" />
                        </li>
                    </div>
                </div>
            </div>
        </div>

    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    // we’re using the router from instantsearch.js. You need to add instantsearch.js to your project dependencies along with vue-instantsearch
    import { history as historyRouter } from 'instantsearch.js/es/lib/routers';
    import { simple as simpleMapping } from 'instantsearch.js/es/lib/stateMappings';

    export default {
        props: ['trending'],

        data() {
            return {
                searchClient: algoliasearch(
                    process.env.MIX_ALGOLIA_APP_ID,
                    process.env.MIX_ALGOLIA_SEARCH,
                ),

                // Vue InstantSearch provides a basic way to activate the browser URL synchronization with the routing option.
                routing: {
                    router: historyRouter(),
                    stateMapping: simpleMapping(),
                },
            };
        },

        computed: {
            hasTrendingThreads() {
                return this.trending.length !== 0
            }
        },

    };
</script>
