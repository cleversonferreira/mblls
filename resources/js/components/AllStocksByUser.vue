<template>
    <div>
        <table class="table-auto">
            <thead>
            <tr>
                <th>Data</th>
                <th>Empresa</th>
                <th>Simbolo</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="stock in stocks.data" :key="stock.id">
                <td>{{ formatDate(stock.created_at) }}</td>
                <td>{{ stock.company_name }}</td>
                <td>{{ stock.symbol }}</td>
                <td>{{ stock.latest_price }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deleteStock(stock.id)">x</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import dayjs from 'dayjs';

export default {
    data() {
        return {
            stocks: []
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
        }
    }
}
</script>
