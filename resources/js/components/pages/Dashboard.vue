<template>
	<div class="container">
        <canvas height="220" id="chart" class="blog-users-by-device m-auto"></canvas>
    </div>
</template>



<script>
    export default {
        data(){
            return{
                expenses: [],
                label: [],
                data: [],
            }
        },
        mounted() {
            axios.get('/get-chart').then(response => {
                this.expenses = response.data;
            });
        },
        watch: {
            expenses: function(){
                this.chart();
            }
        },
        methods: {
            chart() {
                this.expenses.forEach((value, key) => {
                    Vue.set(this.label, this.label.length, value.name);
                    Vue.set(this.data, this.data.length, value.total);
                });

                function getRandomColor() {
                    var color = Math.floor(Math.random() * Math.pow(256, 3)).toString(16);
                    while(color.length < 6) {
                        color = "0" + color;
                    }
                    return "#" + color;
                    }


                var chart = document.getElementById('chart');
                new Chart(chart, {
                    type: 'pie',
                    data: {
                        labels: this.label,
                        datasets: [{
                            label: 'Total Expenses',
                            data: this.data,
                            backgroundColor: [
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                getRandomColor(),
                                
                            ]
                        }]
                    }
                });
            }
        }
        }
 


   
</script>

