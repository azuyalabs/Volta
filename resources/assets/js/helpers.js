import moment from 'moment';
import Dinero from 'dinero.js';

export function relativeDateTime(value) {
    const date = moment(value);

    if (moment().diff(date, 'years') > 2) {
        return 'A long long time ago';
    }

    if (moment().diff(date, 'years') > 1) {
        return `${moment().diff(date, 'years')} years ago`;
    }

    if (moment().diff(date, 'months') === 1) {
        return `${moment().diff(date, 'months')} month ago`;
    }

    if (moment().diff(date, 'months') > 1) {
        return `${moment().diff(date, 'months')} months ago`;
    }

    if (moment().diff(date, 'months') < 1) {
        return `${moment().diff(date, 'days')} days ago`;
    }

    if (moment().diff(date, 'hours') >= 24) {
        return 'A day ago';
    }

    if (moment().diff(date, 'hours') > 1) {
        return `${moment().diff(date, 'hours')} hours ago`;
    }

    if (moment().diff(date, 'minutes') > 59) {
        return 'An hour ago';
    }

    if (moment().diff(date, 'seconds') > 119) {
        return `${moment().diff(date, 'minutes')} minutes ago`;
    }

    if (moment().diff(date, 'seconds') >= 60) {
        return 'A minute ago';
    }

    return 'Just now';
}

export function pluralize(number, word) {
    return numberFormat(number, 0) + ' ' + word + (number === 1 ? '' : 's');
}

/**
 * Formats a duration value into a human readable format.
 *
 * The given duration value in seconds can be formatted into a human friendly format.
 * The duration will be formatted as follows (example): 28 days, 6 hours, and 22 minutes.
 *
 * @param {*} value
 */
export function durationFormat(value) {
    if (!value) {
        return;
    }

    const duration = moment.duration(value, 'seconds');
    const durationElements = [
        ...(duration.weeks() > 0 ? [pluralize(duration.weeks(), 'week')] : []),
        ...(duration.days() > 0 ? [pluralize(duration.days(), 'day')] : []),
        ...(duration.hours() > 0 ? [pluralize(duration.hours(), 'hour')] : []),
        ...(duration.minutes() > 0 ? [pluralize(duration.minutes(), 'minute')] : []),
        ...(duration.seconds() > 0 ? [pluralize(duration.seconds(), 'second')] : []),
    ];

    return durationElements.length == 1
        ? durationElements[0]
        : durationElements.slice(0, durationElements.length - 1).join(', ') +
        ' and ' +
        durationElements[durationElements.length - 1];
}

/**
 * Formats a given numerical value to formatted number.
 *
 * The number is formatted based on the current locale.
 *
 * @param {*} value
 * @param {int} digits
 */
export function numberFormat(value, digits = 2) {
    if (typeof value === 'undefined') {
        return;
    }

    return value.toLocaleString(undefined, {
        maximumFractionDigits: digits,
    });
}

/**
 * Formats a given number to formatted monetary number.
 *
 * If no currency is provided, the currency from the authenticated user is used.
 * This function uses the Dinero.js library as monetary values in Volta are using Martin Fowler's
 * money pattern.
 *
 * @param {*} value
 * @param {*} currency
 */
export function moneyFormat(value, currency) {
    if (typeof value === 'undefined' || isNaN(value)) {
        return;
    }

    Dinero.globalLocale = window.Volta.locale;

    // Currency Subunit mapping (currencies that use an uncommon precision)
    const currencyDefinition = {
        BHD: 3,
        BIF: 0,
        CLF: 4,
        CLP: 0,
        CVE: 0,
        DJF: 0,
        GNF: 0,
        IQD: 3,
        ISK: 0,
        JOD: 3,
        JPY: {
            precision: 0,
            format: '$0,0',
        },
        KMF: 0,
        KRW: 0,
        KWD: 3,
        LYD: 3,
        MGA: 1,
        MRU: 1,
        OMR: 3,
        PYG: 0,
        RWF: 0,
        TND: 3,
        UGX: 0,
        UYI: 0,
        UYW: 4,
        VND: {
            precision: 0,
            format: '$0,0',
        },
        VUV: 0,
        XAF: 0,
        XOF: 0,
        XPF: 0,
    };

    if (typeof currency === 'undefined') {
        currency = window.Volta.currency;
    }

    return Dinero({
        amount: parseInt(value, 10),
        currency: currency,
        precision: currencyDefinition.hasOwnProperty(currency)
            ? currencyDefinition[currency]['precision']
            : 2,
    }).toFormat(
        currencyDefinition.hasOwnProperty(currency)
            ? currencyDefinition[currency]['format']
            : '$0,0.00',
    );
}
