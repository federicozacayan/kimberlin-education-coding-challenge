<template>
    <div class="search" v-if="logged && !detail">
        <input type="text" id="search" placeholder="Search Title"
               v-model="search"
               v-on:keyup="filter"
        >
        <div class="select">
            <select id="cars" class="select capitalize" @change="onChange($event)">
                <option value="Type" class="capitalize"
                        v-for="type in types"
                        v-bind:value="type">{{type}}
                </option>
            </select>
        </div>

        <div class="cards">
            <div class="card shadow" v-for="event in events">
                <h1>{{ event.title }}</h1>
                <div class="flex">
                    <div class="img">
                        <img v-bind:src="event.image" title="title">
                    </div>
                    <div>
                        <div class="meta">
                            <div>Date: {{ getDate(event.id) }}</div>
                            <div>
                                Type: <span class="capitalize">{{ event.type}}</span>
                            </div>
                        </div>
                        <input type="button"
                               value="VIEW DETAILS"
                               v-bind:data=event.id
                               v-on:click="handleButton">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Search', // check HelloWorld component name
        data() {
            return {
                logged: JSON.parse(localStorage.getItem('logged')) || false,
                token: JSON.parse(localStorage.getItem('token')) || false,
                events: [],
                dates: [],
                types: [],
                search: '',
                detail: false
            }
        },
        created() {
            bus.$on('logged', (data, token) => {
                this.logged = data;
                this.token = token;
                this.getData();
            })
            bus.$on('detailFinished', () => {
                this.detail = false
            })
        },
        methods: {
            getData: function () {
                fetch('http://localhost/api/details', {
                    method: 'POST',
                    headers: {
                        "Authorization": `Bearer ${this.token}`,
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
                    //    console.log(JSON.stringify(data.success.dates))
                    this.events = data.success.events
                    this.dates = data.success.dates
                    localStorage.setItem('events', JSON.stringify(this.events));
                    localStorage.setItem('dates', JSON.stringify(this.dates));
                    let types = {}
                    for (const item of this.events) {
                        types[item.type] = item.type
                    }
                    types['free'] = 'free'
                    types['paid'] = 'paid'
                    this.types = types;
                })
                .catch(console.log)
            },


            getDate(id) {
                for (const date of this.dates) {
                    if (date.event_data_id == id) {
                        let tmp = date.date_time.split(' ')[0]
                        tmp = tmp.split('-')
                        tmp = tmp.reverse()
                        return tmp.join('/')
                    }

                }
            },


            filter() {
                let events = JSON.parse(localStorage.getItem('events')) || [];
                this.events = events.filter(event => {
                    return event.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            },


            onChange(e) {
                let events = JSON.parse(localStorage.getItem('events')) || [];
                this.events = events.filter(event => {
                    if (e.target.value == 'free') {
                        return event.paid == 0
                    }
                    if (e.target.value == 'paid') {
                        return event.paid == 1
                    }
                    return event.type.toLowerCase().indexOf(e.target.value.toLowerCase()) > -1
                })
            },


            handleButton(e) {
                bus.$emit('detail', e.target.getAttribute('data'));
                this.detail = true
            }
        },
        mounted() {
            if (this.logged) {
                this.getData()
            }
        }
    }
</script>
