<footer class="bg-indigo-100 text-center lg:text-left mt-auto text-sm">
    <div class="bg-black/5 p-4 text-center text-black">
        <div id="quoteContainer" class="space-y-2">
            <p id="quoteText" class="text-gray-600">Fetching a random quote...</p>
            <p id="quoteAuthor" class="text-gray-600 text-center"></p>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function() {
        function fetchRandomQuote() {
            $.ajax({
                url: 'http://api.quotable.io/random',
                method: 'GET',
                success: function(data) {
                    $('#quoteText').text(data.content);
                    $('#quoteAuthor').text('- ' + data.author);
                },
                error: function(error) {
                    $('#quoteText').text('An error occurred while fetching the quote.');
                    $('#quoteAuthor').text('');
                }
            });
        }

        // Fetch a random quote on page load
        fetchRandomQuote();
    });
</script>
</body>
</html>