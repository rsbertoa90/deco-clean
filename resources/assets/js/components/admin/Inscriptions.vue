<template>
    <div>
        <div class="row">
            <div class="col-4">
                <button 
                    class="btn-block button " 
                    :class="{'btn-success text-white font-weight-bold':seminarType=='insc-presencial',
                            'btn-outline-success':seminarType=='insc-online'}"
                    @click="seminarType = 'insc-presencial'">
                    PRESENCIAL
                </button>
            </div>
            <div class="col-4">
                <button 
                    class="btn-block button  " 
                    :class="{'btn-info text-white font-weight-bold':seminarType=='insc-online',
                            'btn-outline-info ':seminarType=='insc-presencial'}"
                    @click="seminarType = 'insc-online'">
                    ONLINE
                </button>
                </div>
        </div>
            <transition enter-active-class="animated flipInY faster"
                        leave-active-class="animated flipOutX faster"
                        mode="out-in"
                        :duration="{ enter: 100, leave: 50 }">
            
                <component :is="seminarType"></component>
            
            </transition>
       
        <hr>
            <insc-payments></insc-payments>
        
       
        
    </div>
</template>

<script>
    import presencial from './inscriptions/presencial.vue';
    import online from './inscriptions/online.vue';
    import payments from './payments/payments.vue';

    export default {
        data(){
            return {
                seminarType: 'insc-presencial'
            }
        },
        components: {
            'insc-presencial':presencial,
            'insc-online':online,
            'insc-payments':payments
        }
    }
</script>