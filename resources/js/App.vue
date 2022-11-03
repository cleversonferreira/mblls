<template>
    <div class="grid grid-cols-12">
        <div class="col-span-8">
            Empresa: {{stocks.company_name}}
            <div class="font-sans text-black min-h-screen bg-white flex items-center justify-center">
                <div class="border rounded overflow-hidden flex">
<!--                    <input type="text" class="px-4 py-2" v-model="symbol" placeholder="Buscar...">-->
<!--                    <button class="flex items-center justify-center px-4 border-l">-->
<!--                        <svg class="h-4 w-4 text-grey-dark" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>-->
<!--                    </button>-->
                    <form @submit.prevent="searchStock">
                        <input type="text" class="px-4 py-2" v-model="symbol" placeholder="Buscar...">
                        <button type="submit" class="flex items-center justify-center px-4 border-l">
                            <svg class="h-4 w-4 text-grey-dark" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-4">
            <div class="font-sans text-black min-h-screen bg-white flex items-center justify-center">
<!--                <h2 class="text-md font-semibold text-gray-900 dark:text-gray-400">Últimas Buscas:</h2>-->
                <ul class="space-y-1 max-w-md text-gray-500 dark:text-gray-400">
                    <li v-for="stock in stocks.data" :key="stock.id">
                        <p class="text-sm">{{ formatDate(stock.created_at) }} - {{ stock.symbol }}  - {{ stock.latest_price }} (<button class="btn btn-danger" @click="deleteStock(stock.id)">remover</button>)</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from 'dayjs';

export default {
    data() {
        return {
            stocks: {
                company_name: 'a',
            }
        }
    },
    created() {
        this.axios
            .get('/stocks')
            .then(response => {
                this.stocks = response.data;
            });
    },
    methods: {
        formatDate(dateString) {
            const date = dayjs(dateString);
            return date.format('DD/MM/YYYY H:mm:ss');
        },
        deleteStock(id) {
            this.axios
                .delete(`/stocks/${id}`)
                .then(response => {
                    let i = this.stocks.map(data => data.id).indexOf(id);
                    this.stocks.splice(i, 1)
                });
        },
        searchStock() {
            this.axios
                .get(`/stocks/${this.symbol}`)
                .then(response => (
                    console.log(response.data.data)
                ))
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        }
    }
}
</script>
