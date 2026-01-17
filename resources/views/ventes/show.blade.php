<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Vente #{{ $ticket->id_ticket }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .ticket-container {
            background: white;
            width: 100%;
            max-width: 800px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
        }
        
        .ticket-header {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .ticket-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: url("data:image/svg+xml,%3Csvg width='100' height='20' viewBox='0 0 100 20' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20 C20 0, 40 0, 50 20 C60 0, 80 0, 100 20' fill='white'/%3E%3C/svg%3E");
            background-size: 50px 20px;
        }
        
        .ticket-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }
        
        .ticket-id {
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
        }
        
        .ticket-body {
            padding: 40px;
        }
        
        .info-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .info-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #4f46e5;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .info-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-value {
            color: #1e293b;
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .details-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 1.5rem;
            color: #334155;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: #4f46e5;
        }
        
        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .details-table thead {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }
        
        .details-table th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .details-table tbody tr {
            transition: background-color 0.3s ease;
        }
        
        .details-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .details-table tbody tr:hover {
            background: #f1f5f9;
        }
        
        .details-table td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }
        
        .details-table td:last-child {
            font-weight: 700;
            color: #4f46e5;
        }
        
        .total-section {
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        
        .total-label {
            font-size: 1.2rem;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        
        .total-amount {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        
        .currency {
            font-size: 1.5rem;
            vertical-align: top;
            margin-right: 5px;
        }
        
        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 2px solid #e2e8f0;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(90deg, #4338ca 0%, #6d28d9 100%);
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        
        .ticket-footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 10rem;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.03);
            pointer-events: none;
            z-index: 0;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .ticket-container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .btn, .actions {
                display: none;
            }
            
            .watermark {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .ticket-body {
                padding: 20px;
            }
            
            .ticket-title {
                font-size: 1.8rem;
            }
            
            .info-section {
                grid-template-columns: 1fr;
            }
            
            .total-amount {
                font-size: 2.2rem;
            }
            
            .actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Watermark -->
        <div class="watermark">TICKET</div>
        
        <!-- Header -->
        <div class="ticket-header">
            <h1 class="ticket-title">TICKET DE VENTE</h1>
            <div class="ticket-id">#{{ str_pad($ticket->id_ticket, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        
        <!-- Body -->
        <div class="ticket-body">
            <!-- Informations client -->
            <div class="info-section">
                <div class="info-card">
                    <div class="info-label">
                        <i class="fas fa-user"></i> Client
                    </div>
                    <div class="info-value">{{ $ticket->client->nom }} {{ $ticket->client->prenom }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-label">
                        <i class="fas fa-calendar-alt"></i> Date
                    </div>
                    <div class="info-value">{{ date('d/m/Y H:i', strtotime($ticket->date_vente)) }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-label">
                        <i class="fas fa-credit-card"></i> Mode de Paiement
                    </div>
                    <div class="info-value">
                        @if($ticket->mode_paiement == 'espèces')
                            <i class="fas fa-money-bill-wave"></i> Espèces
                        @elseif($ticket->mode_paiement == 'carte')
                            <i class="fas fa-credit-card"></i> Carte Bancaire
                        @else
                            <i class="fas fa-mobile-alt"></i> {{ $ticket->mode_paiement }}
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Détails des produits -->
            <div class="details-section">
                <h2 class="section-title">
                    <i class="fas fa-receipt"></i> Détails des Articles
                </h2>
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticket->detailsVentes as $detail)
                        <tr>
                            <td>
                                <strong>{{ $detail->produit->nom }}</strong>
                                @if($detail->produit->categorie)
                                    <br><small class="text-muted">{{ $detail->produit->categorie->libelle }}</small>
                                @endif
                            </td>
                            <td>{{ $detail->quantite }}</td>
                            <td>{{ number_format($detail->prix_unitaire, 2, ',', ' ') }} €</td>
                            <td>{{ number_format($detail->quantite * $detail->prix_unitaire, 2, ',', ' ') }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Total -->
            <div class="total-section">
                <div class="total-label">
                    <i class="fas fa-file-invoice-dollar"></i> TOTAL À PAYER
                </div>
                <div class="total-amount">
                    <span class="currency">€</span>{{ number_format($ticket->total, 2, ',', ' ') }}
                </div>
            </div>
            
            <!-- Actions -->
            <div class="actions">
                <a href="javascript:window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Imprimer le Ticket
                </a>
                <a href="{{ route('produits.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour aux Produits
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="ticket-footer">
            <p>Merci pour votre achat ! • {{ date('d/m/Y H:i') }} • Ce ticket est une preuve d'achat</p>
        </div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.ticket-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });

        // Ajouter une animation aux cartes
        const cards = document.querySelectorAll('.info-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>