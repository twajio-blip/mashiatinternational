$(document).ready(function() {

    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all();

});

$(document).ready(function() {
    $('.copy-code-btn').click(function() {
        let pre = $(this).closest('.code-container').find('div');
        var text = $(this).closest('.code-container').find('pre').text();
        navigator.clipboard.writeText(text).then(function() {
            pre.append(`<p style="padding: 4px 8px; border: 1px solid gray; border-radius: 6px; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); background-color: rgba(49, 49, 49); color: white; opacity: 0.3;">Text Copied</p>`);
            setTimeout(() => {
                pre.find('p').remove();
            }, 500);
        }).catch(function(error) {
            alert('Failed to copy text: ' + error);
        });
    });
});