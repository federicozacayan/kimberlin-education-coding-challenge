<template>
    <div v-if="!logged" class="login shadow">
        <h1>LOGIN</h1>
        <span class="message red">Authentication Fail</span>
        <input type="text" id="email" v-model="email" placeholder="Email"/>
        <input type="password" id="password" v-model="password" placeholder="Password"/>
        <input type="button" value="LOG IN" v-on:click="handleSubmit">
    </div>
</template>

<script>
    export default {
        name: 'Login',// check HelloWorld component name
        data() {
            return {
                logged: JSON.parse(localStorage.getItem('logged')) || false,
                email: '',
                password: ''
            }
        },
        methods: {
            handleSubmit: function () {
                fetch('http://localhost/api/login', {
                    method: 'POST',
                    body: JSON.stringify({email: this.email, password: this.password}),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8",
                        "Accept": "application/json"
                    }
                })
                .then(res => {
                    if (res.status == 401) {
                        document.querySelector('.message').style.display = 'block';
                        throw Error('Unauthorized');
                    }
                    return res.json()
                })
                .then((data) => {
                    this.logged = true;
                    localStorage.setItem('logged', JSON.stringify(this.logged));
                    localStorage.setItem('token', JSON.stringify(data.success.token));
                    bus.$emit('logged', this.logged, data.success.token);
                })
                .catch(console.log)
            }
        }
    }
</script>
