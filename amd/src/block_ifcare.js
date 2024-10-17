define(['jquery'], function($) {
    return {
        init: function() {
            console.log("block_ifcare.js carregado corretamente.");

            // Adicione aqui seu código de inicialização do modal ou qualquer outra funcionalidade
            $(document).ready(function() {
                const urlParams = new URLSearchParams(window.location.search);
                const coletaid = urlParams.get('coletaid');

                if (coletaid) {
                    $('body').append(`
                        <div id="modalOi" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <p>Oi!</p>
                            </div>
                        </div>
                    `);

                    var modal = document.getElementById('modalOi');
                    var span = document.getElementsByClassName('close')[0];

                    modal.style.display = 'block';

                    span.onclick = function() {
                        modal.style.display = 'none';
                    }

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = 'none';
                        }
                    }
                }
            });
        }
    };
});
