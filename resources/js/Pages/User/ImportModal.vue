<script setup>
import Alert from '@/Components/Alert.vue';
import DangerButton from '@/Components/DangerButton.vue';
import FlashAlert from '@/Components/FlashAlert.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

// To access importModal function
const importModal = ref(null);
const inputFile = ref(null);


const form = useForm({
    file: null,
});

const upload = () => {
    form.post(route('users.import'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => resetInput(),
    });
};

const closeModal = () => {
    importModal.value.close();
    form.clearErrors();
    resetInput();
};

const resetInput=()=>{
    form.reset();
    inputFile.value.value = null; //Form Reset not working for type=file
}

</script>

<template>
    <Modal ref="importModal" @yesEvent="upload" @noEvent="closeModal" :id="'importModal'" :title="' Import users?'" :buttonYes="'Upload'" :buttonType="'primary'" :form="form">
        <FlashAlert v-if="Object.keys(form.errors).length && !form.errors.file" :status="'danger'">
            <label v-for="(message, field) in form.errors">
                {{message}}
            </label>
        </FlashAlert>
        
        <p class="text-primary">
            Make sure the group code is correct.
        </p>

        <div class="mt-6">
            <InputLabel for="file_input" value="Excel File" class="sr-only" />
            <input ref="inputFile" type="file" id="file_input" @input="form.file = $event.target.files[0]" :class="{ 'is-invalid': form.errors.file }" class="form-control"/>
            <InputError :message="form.errors.file" class="mt-2" />
        </div>
    </Modal>
</template>
