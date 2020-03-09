@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 3000,
            killer: true
        }).show();
    </script>

@endif

@if (session('noChange'))

    <script>
        new Noty({
            type: 'danger',
            layout: 'topRight',
            text: "{{ session('noChange') }}",
            timeout: 3000,
            killer: true
        }).show();
    </script>

@endif
