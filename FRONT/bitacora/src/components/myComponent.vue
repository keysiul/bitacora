<template> 
    <div class="myComponent"> 
        <h1>{{message}}</h1>
    </div>
</template>

<script>
    export default {
        name:'myComponent',
        data(){
            return {
                message : 'HelloWorld'
            }
        }
    }
</script>