import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect';

document.addEventListener('alpine:init', function () {
    Alpine.data('referral_system', function (options = {}) {
        return {
            flatpickr_instance: null,
            init() {
                
                if (this.flatpickr_instance !== null) return;

                let config = {
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true, //defaults to false
                            dateFormat: "F Y", //defaults to "F Y"
                            altFormat: "F Y", //defaults to "F Y"
                        })
                    ],
                    defaultDate: "today",
                    maxDate: "today",
                    disableMobile: true,
                    onChange: (selectedDates, dateStr, instance) => {
                        if (selectedDates.length > 0) {
                            this.$wire.dispatch('dateChanged', selectedDates);
                        }
                    },
                    ...options
                };

                this.flatpickr_instance = flatpickr(this.$refs.month_filter, config);
            }
        };
    });

    Alpine.data('referral_system_modal', function (date, options = {}) {
        return {
            flatpickr_instance: null,
            init() {

                if (this.flatpickr_instance !== null) return;

                let config = {
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true, //defaults to false
                            dateFormat: "F Y", //defaults to "F Y"
                            altFormat: "F Y", //defaults to "F Y"
                        })
                    ],
                    defaultDate: date,
                    maxDate: "today",
                    disableMobile: true,
                    onChange: (selectedDates, dateStr, instance) => {
                        if (selectedDates.length > 0) {
                            this.$wire.dispatch('dateChangedModal', selectedDates);
                        }
                    },
                    ...options
                }

                this.flatpickr_instance = flatpickr(this.$refs.month_filter, config);
            },
        };
    });

    Alpine.data('date_range_picker', function (date_picker_id, { from, to }, maxDateToday) {
        return {
            flatpickr: null,
            fromDate: null,
            toDate: null,
            init () {                
                // console.log(no_max_date);
                this.fromDate = from;
                this.toDate = to;
                
                this.flatpickr = flatpickr("#"+ date_picker_id, {
                    mode: "range",
                    dateFormat: "Y-m-d", // Example: "2025-08-06 to 2025-08-10"
                    maxDate: maxDateToday ? "today" : null,
                    defaultDate: [from, to],

                    onChange: (selectedDates, dateStr, instance) => {
                        if (instance.selectedDates.length === 2) {
                            const dateStrSplit = dateStr.split(' ');
    
                            let from = dateStrSplit[0]; // get the start date
                            let to = dateStrSplit.length === 1 ? from : dateStrSplit[2]; // if dateStrSplit has more than 1 element it means there's selected end date
    
                            this.$wire.dispatch('date-range-picker-' + date_picker_id, {
                                from: from,
                                to: to
                            });
                        }
                    },

                });

                this.$wire.on('clear-' + date_picker_id, () => {
                    this.flatpickr.setDate([this.fromDate, this.toDate], true);
                });
            },
        }
    })
});