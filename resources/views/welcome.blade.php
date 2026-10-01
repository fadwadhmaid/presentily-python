<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentily - Apprends Python en t'amusant</title>
    <!-- CDN Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Config Tailwind via CDN -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandCyber: '#FDE047',
                        brandMint: '#4ADE80',
                    }
                }
            }
        }
    </script>
    
    <!-- STYLES CRITIQUES POUR LE MODAL -->
    <style>
        /* Force le modal à ne pas dépasser */
        #authModal {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        #authModalCard {
            width: 100% !important;
            max-width: 400px !important;
            margin: 0 auto !important;
            flex-shrink: 0 !important;
        }
        
        /* Empêche le débordement */
        body, #app {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }
        
        /* Reset des conteneurs */
        .container, .max-w-7xl {
            max-width: 100% !important;
        }
    </style>
    
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <welcome-component></welcome-component>
    </div>
</body>
</html>