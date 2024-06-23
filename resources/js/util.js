export const dateHumanFormat = (dateString) => {
    if (!dateString) return '-';

    const date = new Date(dateString);
    const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
};

export const currency = (value, currency) => {
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: currency,
    });
    return formatter.format(value);
};

export const rupiahCurrency = (value) => {
    return currency(value, 'IDR');
};

export const currencySymbol = (currency) => {
    const symbol = {
        'USD': '$',
        'EUR': '€',
        'GBP': '£',
        'JPY': '¥',
        'AUD': 'A$',
        'CAD': 'C$',
        'CHF': 'CHF',
        'CNY': '¥',
        'SEK': 'kr',
        'NZD': 'NZ$',
        'INR': '₹',
        'BRL': 'R$',
        'RUB': '₽',
        'ZAR': 'R',
        'TRY': '₺',
        'MXN': '$',
        'SGD': 'S$',
        'HKD': 'HK$',
        'NOK': 'kr',
        'KRW': '₩',
        'IDR': 'Rp',
        'MYR': 'RM',
        'PHP': '₱',
        'THB': '฿',
        'VND': '₫',
        'MMK': 'K',
        'KHR': '៛',
        'LAK': '₭',
        'BND': 'B$',
        'AED': 'د.إ',
        'SAR': 'ر.س',
        'QAR': 'ر.ق',
        'KWD': 'د.ك',
        'BHD': 'ب.د',
        'OMR': 'ر.ع',
        'IRR': '﷼',
        'JOD': 'د.ا',
        'LBP': 'ل.ل',
    };
    return symbol[currency];
};

export const snakeCaseToTitleCase = (input) => {
    return input
        .split('_')
        .map(word => word[0].toUpperCase() + word.slice(1))
        .join(' ');
};
