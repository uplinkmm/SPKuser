<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-8 min-h-[100vh]">
        <div class="flex justify-between py-4 px-0 lg:px-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class=" text-black text-base">
                ပြကဒိန်
            </p>
            <div class="flex gap-x-4">
                <button>
                    <i class="fal fa-search"></i>
                </button>
                <button>
                    <i class="fal fa-bell"></i>
                </button>
            </div>
        </div>

        <FullCalendar :options="calendarOptions" ref="cc" @click="getSelectedMonth()"></FullCalendar>


    </div>
</template>

<script>
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import { getApiData, postApiData, deleteApiData } from '../../utilities/ajax-helpers';
import { getCurrentDate,convertToFriendlyDate ,convertToMonth } from '../../utilities/datetime-helpers';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            datetest:null,
            calendarOptions: {
                plugins: [dayGridPlugin],
                initialView: 'dayGridMonth',
                events: [],
                weekends: false ,
                displayEventTime : false,
                titleFormat: {
                    month :'short',
                    year: 'numeric'
                },
                height:'auto',
            },
            month: null,
            year: null,
            twoDList:[],
            monthNumber:null,


        };
    },

    methods: {
        async getMonthAndYear(){
            this.year = getCurrentDate().substring(0, 4)
            this.month = getCurrentDate().substring(5, 7)
        },
        async getMonthlyResult() {
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/2d/results/monthly?month=' + this.month+ '&year='+ this.year });
            if (response.data) {
                this.twoDList = response.data;
                this.twoDList.forEach((result, index)=>{
                    if(result.open_time == '16:30:00'){
                        if(this.twoDList[index - 1].open_time == '15:00:00'){
                            this.twoDList.splice(index-1, 1);
                        }
                    }
                });
                this.calendarOptions.events = this.twoDList
            }
            else {
            }
        },

        async getSelectedMonth() {
            let calendarApi = this.$refs.cc.getApi();
            this.monthNumber = convertToMonth(calendarApi.currentData.viewTitle).substring(0, 3);
            this.getMonthAndYearNumber();
            this.year = convertToMonth(calendarApi.currentData.viewTitle).substring(5, 9);
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/2d/results/monthly?month=' + this.month + '&year=' + this.year });
            if (response.data) {
                this.twoDList = response.data;
                this.twoDList.forEach((result, index)=>{
                    if(result.open_time == '16:30:00'){
                        if(this.twoDList[index - 1].open_time == '15:00:00'){
                            this.twoDList.splice(index-1, 1);
                        }
                    }
                });

                this.calendarOptions.events = this.twoDList
            }
            else {
            }

        },
        getMonthAndYearNumber() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const index = months.indexOf(this.monthNumber);
            if(index > 8){
                this.month = index + 1
            }
            else{
                this.month = '0' + (index + 1);
            }

        },
        toggleWeekends: function () {
            this.calendarOptions.weekends = !this.calendarOptions.weekends
        },


    },

    created() {
    },

    mounted() {
        this.getMonthAndYear();
        this.getMonthlyResult();
        initTWE({ Modal, Ripple });

    }
}
</script>
