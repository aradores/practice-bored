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

    Alpine.data('date_range_picker', function (date_picker_id, { from = null, to = null }, maxDateToday = false) {
        return {
            flatpickr: null,
            fromDate: from,
            toDate: to,

            init() {
                this.flatpickr = flatpickr("#" + date_picker_id, {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    maxDate: maxDateToday ? "today" : null,
                    defaultDate: from && to ? [from, to] : null,
                    appendTo: this.$root,
                    // positionElement: document.querySelector("#" + date_picker_id),
                    onChange: (selectedDates, dateStr, instance) => {
                        let start = null, end = null;

                        if (selectedDates.length === 2) {
                            start = instance.formatDate(selectedDates[0], "Y-m-d");
                            end = instance.formatDate(selectedDates[1], "Y-m-d");
                        } else if (selectedDates.length === 1) {
                            start = end = instance.formatDate(selectedDates[0], "Y-m-d");
                        }

                        this.$wire.dispatch('date-range-picker-' + date_picker_id, {
                            from: start,
                            to: end
                        });
                    }
                });

                this.$wire.on('clear-date-range-' + date_picker_id, () => {

                    if (this.flatpickr) {
                        this.flatpickr.clear();
                    }

                    this.fromDate = null;
                    this.toDate = null;

                    this.$wire.dispatch('date-range-picker-' + date_picker_id, {
                        from: null,
                        to: null
                    });
                });
            }
        }
    });


   Alpine.data('date_time_picker', function (pickerId = null, date = null, minDateEnabled = false) {
        return {
            flatpickr_instance: null,
            currentDate: date,
            init() {
                this.flatpickr_instance = flatpickr(this.$refs.datetime_picker, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    defaultDate: this.currentDate,
                    disableMobile: true,
                    minuteIncrement: 1,
                    appendTo: this.$root,
                    minDate: minDateEnabled ? new Date() : null,
                    onChange: (selectedDates, dateStr, instance) => {
                        if (selectedDates.length > 0) {
                            const selectedDate = instance.formatDate(selectedDates[0], "Y-m-d H:i");

                            if (pickerId) {
                                this.$wire.dispatch('date-time-changed-' + pickerId, {date_time : selectedDate});
                            } else {
                                this.$wire.dispatch('date-time-changed', selectedDate);
                            }
                        }
                    }
                });

                if (pickerId) {
                    this.$wire.on('clear-' + pickerId, () => {
                        this.flatpickr_instance.setDate(this.currentDate, true);
                    });
                }
            }
        };
    });
});
