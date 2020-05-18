<template>
    <ais-instant-search :search-client="searchClient" index-name="threads">

        <!--Algolia -> Indices -> Configuration -> FILTERING AND FACETING -> Facets-->
        <ais-refinement-list attribute="channel.name" />

        <ais-search-box />

        <ais-hits>
            <div slot="item" slot-scope="{ item }">
                <a :href="item.path"><ais-highlight :hit="item" attribute="title" /></a>
            </div>
        </ais-hits>

    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    process.env.MIX_ALGOLIA_APP_ID,
                    process.env.MIX_ALGOLIA_SEARCH
                ),
            };
        },
    };
</script>
