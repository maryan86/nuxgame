$(document).ready(function() {
    const token = $('#gameContainer').data('token');

    if (!token) {
        return;
    }

    $('#playBtn').click(function() {
        $.ajax({
            url: `/game/${token}/play`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const gameData = response.data;
                const resultClass = gameData.is_win
                    ? 'bg-green-100 border-green-400 text-green-700'
                    : 'bg-red-100 border-red-400 text-red-700';

                $('#gameResult').html(`
                    <div class="border ${resultClass} rounded p-4">
                        <p class="font-bold text-lg mb-2">Result: ${gameData.result}</p>
                        <p>Random Number: ${gameData.random_number}</p>
                        <p>Win Amount: $${gameData.win_amount}</p>
                    </div>
                `).removeClass('hidden');

                $('#historyContainer').addClass('hidden');
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || xhr.responseJSON?.error || 'Something went wrong';
                alert('Error: ' + message);
            }
        });
    });

    $('#historyBtn').click(function() {
        $.ajax({
            url: `/game/${token}/history`,
            method: 'GET',
            success: function(response) {
                const history = response.data || [];

                if (history.length === 0) {
                    $('#historyContent').html('<p class="text-gray-500">No game history yet.</p>');
                } else {
                    let html = '<div class="space-y-2">';
                    history.forEach(function(item) {
                        const resultClass = item.is_win ? 'bg-green-50' : 'bg-red-50';
                        html += `
                            <div class="border ${resultClass} rounded p-3">
                                <p><strong>Result:</strong> ${item.result}</p>
                                <p><strong>Number:</strong> ${item.random_number}</p>
                                <p><strong>Amount:</strong> $${item.win_amount}</p>
                            </div>
                        `;
                    });
                    html += '</div>';
                    $('#historyContent').html(html);
                }

                $('#historyContainer').removeClass('hidden');
                $('#gameResult').addClass('hidden');
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || xhr.responseJSON?.error || 'Something went wrong';
                alert('Error: ' + message);
            }
        });
    });
});