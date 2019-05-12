import moment from 'moment-timezone';
import momentDurationFormatSetup from 'moment-duration-format';

/**
 * Checks whether a given date took place recently (within the given period)
 *
 * @param {*} value the date value (string)
 * @param {*} period the number days to look back
 */
export function isNew(value, period = 7) {
    const date = moment(value)
        .tz(Intl.DateTimeFormat().resolvedOptions().timeZone)
        .locale(window.Volta.locale);

    const fence = moment().subtract(period, 'days');

    return fence.isSameOrBefore(date);
}

/**
 * Formats a given time duration
 *
 * @param {*} duration the time duration (in seconds)
 */
export function formatPrintJobDuration(duration) {
    momentDurationFormatSetup(moment);

    return moment
        .duration(duration, 'seconds')
        .locale(window.Volta.locale)
        .format('dd:hh:mm:ss', {
            trim: false,
        });
}

/**
 * Returns the estimated time of arrival for the given period (in seconds)
 *
 * The time is formatted with the locale from the authenticated user.
 *
 * @param {*} seconds the period (in seconds)
 */
export function formatETA(seconds) {
    const eta = moment().add(seconds, 's');
    eta.locale(window.Volta.locale);

    return eta.format('LTS');
}

/**
 * Formats a given number value.
 *
 * The number is formatted with the locale from the authenticated user.
 *
 * @param {*} value the date value (string)
 * @param {*} digits the number of decimal digits to use
 */
export function numberFormat(value, digits = 2) {
    return new Intl.NumberFormat(window.Volta.locale, { maximumFractionDigits: digits }).format(
        value
    );
}

/**
 * Formats a given date value.
 *
 * The date is formatted with the locale from the authenticated user.
 *
 * @param {*} value the date value (string) in UTC
 * @param {*} format the format pattern to use
 */
export function dateFormat(value, format = 'D-M-Y') {
    const date = moment
        .tz(value, 'UTC')
        .tz(Intl.DateTimeFormat().resolvedOptions().timeZone)
        .locale(window.Volta.locale);

    return date.format(format);
}

/**
 * Displays a time period (difference) in human readable format.
 *
 * The value is formatted with the locale of the authenticated user.
 *
 * @param {*} value the date the time period needs to be based on
 */
export function diffForHumans(value) {
    const date = moment(value)
        .tz(Intl.DateTimeFormat().resolvedOptions().timeZone)
        .locale(window.Volta.locale);

    if (moment().isSame(date, 'd')) {
        return 'Today';
    }

    if (moment().isAfter(date)) {
        return date.fromNow(false);
    }

    return 'in ' + date.toNow(true);
}

export function addClassModifiers(base, modifiers = []) {
    if (!Array.isArray(modifiers)) {
        modifiers = modifiers.split(' ');
    }

    modifiers = modifiers.map(modifier => `${base}--${modifier}`);

    return [base, ...modifiers];
}

export function positionToGridAreaNotation(position) {
    const [from, to = null] = position.toLowerCase().split(':');

    if (from.length !== 2 || (to && to.length !== 2)) {
        return;
    }

    const areaFrom = `${from[1]} / ${indexInAlphabet(from[0])}`;
    return to ? `${areaFrom} / ${Number(to[1]) + 1} / ${indexInAlphabet(to[0]) + 1}` : areaFrom;
}

function indexInAlphabet(character) {
    const index = character.toLowerCase().charCodeAt(0) - 96;
    return index < 1 ? 1 : index;
}
