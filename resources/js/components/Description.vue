<template>
    <div v-if="detail" class="description">
        <div class="cards">
            <div class="card shadow">
                <h1>{{ title }}</h1>
                <div class="img">
                    <img v-bind:src="image" v-bind:title="title">
                </div>
            </div>

            <div class="card shadow flex">
                <div class="meta">
                    <div>Date: {{ getDate(id) }}</div>
                    <div>
                        Type: <span class="capitalize">{{ type }}</span>
                    </div>
                </div>
                <div>
                    <span class="message green">Event Booked Successfully</span>
                    <div class="select">
                        <select class="select" @change="onChange($event)">
                            <option>Choose a time</option>
                            <option v-bind:value="date.id"
                                    v-for="date in dates">
                                {{ date.date_time.split(' ')[1] }}
                            </option>
                        </select>
                    </div>
                    <input type="button" value="Book the event" v-on:click="booking">
                </div>
            </div>

            <div class="card shadow">
                <h2>Description</h2>
                <p v-html="description"></p>
                <i v-on:click="back" class="back"> Go back &rarr;</i>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: 'Description',// check HelloWorld component name
        data() {
            return {
                detail: false,
                id: '',
                title: '',
                description: '',
                image: '',
                type: '',
                dates: [],
                date: null
            }
        },
        methods: {
            getDate(id) {
                let dates = JSON.parse(localStorage.getItem('dates')) || [];
                for (const date of dates) {
                    if (date.event_data_id == id) {
                        let tmp = date.date_time.split(' ')[0]
                        tmp = tmp.split('-')
                        tmp = tmp.reverse()
                        return tmp.join('/')
                    }
                }
            },
            getDateFromId(id) {
                let dates = JSON.parse(localStorage.getItem('dates')) || [];
                let datesFromId = []
                for (const date of dates) {
                    if (date.event_data_id == id) {
                        datesFromId.push(date)
                        console.log(date)
                    }
                }

                this.dates = datesFromId;
            },

            back() {
                bus.$emit('detailFinished');
                this.detail = false
            },

            onChange(e) {
                this.date = e.target.value
            },

            booking() {
                if (this.date == null) {
                    alert("You must choose a time.")
                    return;
                }

                let boolean = confirm("Do you comfim this booking?");
                if (!boolean) {
                    return false;
                }

                let token = JSON.parse(localStorage.getItem('token'));

                fetch('http://localhost/api/booking/', {
                    method: 'POST',
                    body: JSON.stringify({event_date: this.date}),
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        "Content-type": "application/json; charset=UTF-8",
                        "Accept": "application/json"
                    }
                })
                .then(res => {
                    if (res.status == 401) {
                        throw Error('Unauthorized');
                    }
                    return res.json()
                })
                .then((data) => {
                    if (data.success) {
                        document.querySelector('.message').style.display = 'block';
                    }

                })
                .catch(console.log)
            }
        },
        created() {
            bus.$on('detail', (id) => {
                let events = JSON.parse(localStorage.getItem('events')) || [];
                for (const event of events) {
                    if (event.id == id) {
                        this.id = event.id
                        this.title = event.title
                        this.description = event.description
                        this.image = event.image
                        this.type = event.type
                        this.getDateFromId(id)
                        this.detail = true
                        this.date = null
                        return;
                    }

                }
            })
        },
    }
</script>
