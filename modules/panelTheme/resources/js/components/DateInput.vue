<template>
    <div class="mb-6" :class="className">
        <date-picker
            :type="type"
            :format="format"
            :display-format="display_format"
            locale="fa"
            :label="label!=='false' ? label : ''"
            v-model="date"
            :max="max"
            :min="min"
        >
        </date-picker>
        <input type="hidden" :name="name" v-model="date"/>

    </div>
</template>

<script>
import methods from "../methods";

export default {
    name: "DateInput",
    props: ['value', 'label', 'name', 'args'],
    mixins: [methods],
    data() {
        return {
            date: null,
            menu: false,
            className: 'c-field',
            rules: [],
            min: '',
            max: '',
            format: 'YYYY-MM-DD HH:mm',
            display_format: "jYYYY-jMM-jDD HH:mm",
            type: 'datetime',
        }
    },
    mounted() {
        if (this.value !== '') {
            this.date = this.value;
        }
        if (this.value === 'null') {
            this.date = '';
        }
        if (this.args != null) {
            this.options = this.args;
            if (this.options['validate'] !== undefined) {
                this.setValidate(this.options['validate']);
            }
            if (this.options['class'] !== undefined) {
                this.className = this.className + ' ' + this.options['class'];
            }
            if (this.options['min'] !== undefined) {
                this.min = this.options['min'];
            }
            if (this.options['type'] !== undefined) {
                this.type = this.options['type'];
            }
            if (this.options['format'] !== undefined) {
                this.format = this.options['format'];
            }
            if (this.options['display_format'] !== undefined) {
                this.display_format = this.options['display_format'];
            }
            if (this.options['max'] !== undefined && this.options['max'] === 'today') {
                let today = new Date();
                this.max = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
            }
            if (this.options['max'] !== undefined) {
                this.max = this.options['max'];
            }
        }
    },
    methods: {
        gregorian_to_jalali(gy, gm, gd) {
            var g_d_m, jy, jm, jd, gy2, days;
            g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            gy2 = (gm > 2) ? (gy + 1) : gy;
            days = 355666 + (365 * gy) + ~~((gy2 + 3) / 4) - ~~((gy2 + 99) / 100) + ~~((gy2 + 399) / 400) + gd + g_d_m[gm - 1];
            jy = -1595 + (33 * ~~(days / 12053));
            days %= 12053;
            jy += 4 * ~~(days / 1461);
            days %= 1461;
            if (days > 365) {
                jy += ~~((days - 1) / 365);
                days = (days - 1) % 365;
            }
            if (days < 186) {
                jm = 1 + ~~(days / 31);
                jd = 1 + (days % 31);
            } else {
                jm = 7 + ~~((days - 186) / 30);
                jd = 1 + ((days - 186) % 30);
            }
            return [jy, jm, jd];
        },
        jalali_to_gregorian(jy, jm, jd) {
            var sal_a, gy, gm, gd, days;
            jy += 1595;
            days = -355668 + (365 * jy) + (~~(jy / 33) * 8) + ~~(((jy % 33) + 3) / 4) + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
            gy = 400 * ~~(days / 146097);
            days %= 146097;
            if (days > 36524) {
                gy += 100 * ~~(--days / 36524);
                days %= 36524;
                if (days >= 365) days++;
            }
            gy += 4 * ~~(days / 1461);
            days %= 1461;
            if (days > 365) {
                gy += ~~((days - 1) / 365);
                days = (days - 1) % 365;
            }
            gd = days + 1;
            sal_a = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            for (gm = 0; gm < 13 && gd > sal_a[gm]; gm++) gd -= sal_a[gm];
            return [gy, gm, gd];
        },
        formatData: function (date) {
            if (!date) return null;
            const [year, month, day] = date.split('-');
            const jalali = this.gregorian_to_jalali(
                parseInt(year),
                parseInt(month),
                parseInt(day)
            );
            return `${jalali[0]}/${jalali[1]}/${jalali[2]}`;
        },
        parseDate: function (date) {
            if (!date) return null;
            const [year, month, day] = date.split('/');
            const gregorian = this.jalali_to_gregorian(
                parseInt(year),
                parseInt(month),
                parseInt(day)
            );
            let m = gregorian[1];
            if (m.length === 1) {
                m = '0' + m;
            }

            let d = gregorian[2];
            if (d.length === 1) {
                d = '0' + m;
            }

            return `${gregorian[0]}-0${m}-${d}`;
        }
    },
    watch: {
        date(val) {
            this.dateFormatted = this.formatData(this.date);
        }
    }
}
</script>
