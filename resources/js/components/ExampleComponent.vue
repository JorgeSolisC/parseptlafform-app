<template>
    <div class="container">
        <div class="row justify-content-center">
            <div style="margin: auto; padding: 15rem">
                <div class="card">
                    <div class="card-header" style="font-size: 1.5rem; font-weight: 900;">Listado de evento LiveQuery:</div>
                    <div class="card-body" v-for="(v, k) in items" :key="k">
                        <b>{{ v.label }}</b><br>
                        <div style="padding-left: 1rem;">
                            {{ v.data }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePusherEvent } from '../composables/pusher.js';
import { useParseEvent } from '../composables/parselive.js';
import { onMounted, ref } from 'vue';

const event = usePusherEvent();

const items = ref([])

event.bind('parse-updated', function (data) {
    console.log(data);
});

onMounted(async () => {
    try {
        const eventParse = await useParseEvent();

        eventParse.on('open', (obj) => {
            items.value.push({label:'Abrir parse ', data: obj})
            console.log('Abrir parse ', obj);
        });

        eventParse.on('create', (obj) => {
            items.value.push({label: 'Nuevo objeto creado', data: obj})
            console.log('Nuevo objeto creado:', obj);
        });

        eventParse.on('update', (obj) => {
            items.value.push({label: 'Objeto actualizado', data: obj})
            console.log('Objeto actualizado:', obj);
        });

        eventParse.on('delete', (obj) => {
            items.value.push({label: 'Objeto eliminado', data: obj})
            console.log('Objeto eliminado:', obj);
        });

        eventParse.on('error', (error) => {
            items.value.push({label: 'Error event parse', data: obj})
            console.log(error);
        });

    } catch (error) {
        console.error('Error al suscribirse a eventos LiveQuery:', error);
    }
});

</script>
