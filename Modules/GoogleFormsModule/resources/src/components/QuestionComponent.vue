
<template>
<div class="questions-ctr">
        <div class="progress">
            <div class="bar"
            :style="{ width: `${(currentQuestion / questions.length)*100}%`}"
            ></div>
            <div class="status">{{currentQuestion}} out of {{ questions.length }} questions answered</div>
        </div>

        <div  v-for="(question,i) in questions" :key="i" class="single-question">
            <div class="question">{{question.q}}</div>
            <div v-for="(answers,i) in question.answers" :key="i" class="answers">
                <div @click.prevent="selectAnswer(answers.is_correct)" class="answer">{{answers.text}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            questions:{
                type:Array,
            },
            currentQuestion:{
                type:Number
            }
        },
        emits:['question-answer'],
        methods:{
            selectAnswer(is_correct){
                this.$emit('question-answer',is_correct)
            }
        }
       
    }
</script>

<style  >

</style>