<template>
<div class="mt-5">
    <QuizComponent/>
</div>
</template>

<script>
import QuestionComponent from '../components/QuestionComponent.vue';
import QuizComponent from '../components/QuizComponent.vue';
import ResultComponent from '../components/ResultComponent.vue';
// import PreviewView from './PreviewView.vue';

    export default {
        components:{
            ResultComponent,
            QuestionComponent,
            QuizComponent
        },

       data(){
        return{
            currentQuestion : 0,
            correctedAnswer : 0 ,
            questions: [
                {
                    q: 'What is 2 + 2?',
                    answers: [
                        {
                            text: '4',
                            is_correct: true
                        },
                        {
                            text: '3',
                            is_correct: false
                        },
                        {
                            text: 'Fish',
                            is_correct: false
                        },
                        {
                            text: '5',
                            is_correct: false
                        }
                    ]
                },
                {
                    q: 'How many letters are in the word "Banana"?',
                    answers: [
                        {
                            text: '5',
                            is_correct: false
                        },
                        {
                            text: '7',
                            is_correct: false
                        },
                        {
                            text: '6',
                            is_correct: true
                        },
                        {
                            text: '12',
                            is_correct: false
                        }
                    ]
                },
                {
                    q: 'Find the missing letter: C_ke',
                    answers: [
                        {
                            text: 'e',
                            is_correct: false
                        },
                        {
                            text: 'a',
                            is_correct: true
                        },
                        {
                            text: 'i',
                            is_correct: false
                        }
                    ]
                },
            ],
            results: [
                {
                    min: 0,
                    max: 2,
                    title: "Try again!",
                    desc: "Do a little more studying and you may succeed!"
                },
                {
                    min: 3,
                    max: 3,
                    title: "Wow, you're a genius!",
                    desc: "Studying has definitely paid off for you!"
                }
            ]
        }
       },
       methods:{
        questionAnswer(is_correct){
          if (is_correct) {
            this.correctedAnswer++
          }
          this.currentQuestion++
        }
       }
    }
</script>

<style >

.ctr {
  height: 100%;
  margin: 0 auto;
  max-width: 600px;
  width: 100%;
  box-sizing: border-box;
  position: relative;
}
.ctr .questions-ctr {
  position: relative;
  width: 100%;
}
.ctr .question {
  width: 100%;
  padding: 20px;
  font-size: 32px;
  font-weight: bold;
  text-align: center;
  background-color: #00ca8c;
  color: #fff;
  box-sizing: border-box;
}
.ctr .single-question {
  position: relative;
  width: 100%;
}
.ctr .answer {
  border: 1px solid #8e959f;
  padding: 20px;
  font-size: 18px;
  width: 100%;
  background-color: #fff;
  transition: 0.2s linear all;
}
.ctr .answer span {
  display: inline-block;
  margin-left: 5px;
  font-size: 0.75em;
  font-style: italic;
}
.ctr .progress {
  height: 50px;
  margin-top: 10px;
  background-color: #ddd;
  position: relative;
}
.ctr .bar {
  height: 50px;
  background-color: #ff6372;
  transition: all 0.3s linear;
}
.ctr .status {
  position: absolute;
  top: 15px;
  left: 0;
  text-align: center;
  color: #fff;
  width: 100%;
}
.ctr .answer:not(.is-answered) {
  cursor: pointer;
}
.ctr .answer:not(.is-answered):hover {
  background-color: #8ce200;
  border-color: #8ce200;
  color: #fff;
}

.ctr .title {
  width: 100%;
  padding: 20px;
  font-size: 32px;
  font-weight: bold;
  text-align: center;
  background-color: #12cbc4;
  color: #fff;
  box-sizing: border-box;
}
.ctr  .desc {
  border: 1px solid #8e959f;
  padding: 20px;
  font-size: 18px;
  width: 100%;
  background-color: #fff;
  transition: 0.4s linear all;
  text-align: center;
}
.fade-enter-from {
  opacity: 0;
}
.fade-enter-active {
  transition: all 0.3s linear;
}
.fade-leave-active {
  transition: all 0.3s linear;
  opacity: 0;
  position: absolute;
}
.fade-leave-to {
  opacity: 0;
}

.ctr  .reset-btn {
  background-color: #ff6372;
    border: 0;
    font-size: 22px;
    color: #fff;
    padding: 10px 25px;
    margin: 10px auto;
    display: block;
}

.ctr   .result{
  width: 100%;
}


.reset-btn:active, .reset-btn:focus, .reset-btn:hover{
  border: 0;
  outline: 0;
}

</style>
