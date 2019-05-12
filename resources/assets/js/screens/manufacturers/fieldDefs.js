export default i18n => {
    return [
        {
            name: 'name',
            title: () => i18n.t('fields.name.text'),
            sortField: 'name',
            width: '35%',
        },
        {
            name: 'country',
            title: i18n.t('fields.country.text'),
            width: '35%',
            sortField: 'country',
        },
        {
            name: '__slot:actions',
            title: '',
            width: '8%',
            titleClass: 'center aligned',
            dataClass: 'center aligned',
        },
        {
            name: '__slot:custom_field_1',
            title: i18n.t('fields.supplies.text'),
            width: '22%',
            titleClass: 'center aligned',
            dataClass: 'center aligned',
        },
    ];
};
