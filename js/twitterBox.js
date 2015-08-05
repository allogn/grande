$('.twitterBox').twittie({
    dateFormat: '%d. %b, %Y',
    template: '<dl><dt>{{date}}</dt><dd>{{tweet}}</dd></dl>',
    count: 10
});