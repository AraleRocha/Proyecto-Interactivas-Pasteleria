<style>
    .amo-footer{
        margin-top: 80px;
        background: linear-gradient(135deg, #2f1408 0%, #5c2411 45%, #8d3a15 100%);
        color: rgba(255,255,255,0.92);
        position: relative;
        overflow: hidden;
    }

    .amo-footer::before{
        content:'';
        position:absolute;
        inset:0;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,0.08), transparent 35%),
            radial-gradient(circle at bottom left, rgba(255,203,198,0.12), transparent 30%);
        pointer-events:none;
    }

    .amo-footer-wrap{
        position: relative;
        z-index: 2;
        max-width: 1280px;
        margin: 0 auto;
        padding: 72px 28px 32px;
    }

    .amo-footer-top{
        display:grid;
        grid-template-columns: 1.4fr 1fr 1fr 1fr;
        gap: 42px;
        margin-bottom: 42px;
    }

    .amo-footer-brand h2{
        font-family:'Playfair Display', serif;
        font-size: 38px;
        font-weight:700;
        margin:0 0 10px;
        color:#fff4ef;
    }

    .amo-footer-brand p{
        color: rgba(255,255,255,0.72);
        line-height:1.8;
        font-size:14px;
        max-width: 360px;
    }

    .amo-footer-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:8px 14px;
        border-radius:999px;
        margin-top:18px;
        background: rgba(255,255,255,0.10);
        backdrop-filter: blur(10px);
        border:1px solid rgba(255,255,255,0.12);
        font-size:12px;
        font-weight:600;
    }

    .amo-footer-title{
        font-size:15px;
        font-weight:700;
        margin-bottom:18px;
        color:#fff7f3;
        letter-spacing:0.04em;
    }

    .amo-footer-links{
        display:flex;
        flex-direction:column;
        gap:12px;
    }

    .amo-footer-links a,
    .amo-footer-links span{
        color: rgba(255,255,255,0.72);
        text-decoration:none;
        font-size:14px;
        transition: all .2s ease;
    }

    .amo-footer-links a:hover{
        color:#ffffff;
        transform: translateX(2px);
    }

    .amo-socials{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        margin-top: 10px;
    }

    .amo-social{
        width:44px;
        height:44px;
        border-radius:16px;
        background: rgba(255,255,255,0.10);
        border:1px solid rgba(255,255,255,0.10);
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        color:white;
        transition: all .22s ease;
        backdrop-filter: blur(8px);
    }

    .amo-social:hover{
        transform: translateY(-3px);
        background: rgba(255,255,255,0.18);
        box-shadow: 0 12px 24px rgba(0,0,0,0.18);
    }

    .amo-footer-bottom{
        border-top:1px solid rgba(255,255,255,0.12);
        padding-top:22px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        flex-wrap:wrap;
    }

    .amo-footer-copy{
        font-size:13px;
        color: rgba(255,255,255,0.58);
    }

    .amo-footer-note{
        display:flex;
        align-items:center;
        gap:8px;
        font-size:13px;
        color: rgba(255,255,255,0.68);
    }

    .amo-footer-note .material-symbols-outlined{
        font-size:18px;
    }

    @media (max-width: 920px){
        .amo-footer-top{
            grid-template-columns:1fr 1fr;
        }
    }

    @media (max-width: 640px){
        .amo-footer-top{
            grid-template-columns:1fr;
        }

        .amo-footer-brand h2{
            font-size:32px;
        }

        .amo-footer-bottom{
            flex-direction:column;
            align-items:flex-start;
        }
    }
</style>

<footer class="amo-footer">
    <div class="amo-footer-wrap">
        <div class="amo-footer-top">
            {{-- Marca --}}
            <div class="amo-footer-brand">
                <h2>Amoretti</h2>
                <p>
                    Pastelería artesanal inspirada en momentos especiales.
                    Cada creación está elaborada cuidadosamente para convertir
                    celebraciones en recuerdos inolvidables.
                </p>
                <div class="amo-footer-badge">
                    <span class="material-symbols-outlined">cake</span>
                    Elaboración artesanal 
                </div>
            </div>

            {{-- Información --}}
            <div>
                <h3 class="amo-footer-title">Información</h3>
                <div class="amo-footer-links">
                    <span>Pedidos únicamente en sucursal</span>
                    <span>No realizamos envíos a domicilio</span>
                    <span>No manejamos personalizaciones</span>
                    <span>Horarios sujetos a disponibilidad</span>
                </div>
            </div>

            {{-- Contacto --}}
            <div>
                <h3 class="amo-footer-title">Contacto</h3>
                <div class="amo-footer-links">
                    <span>San Luis Potosí, México</span>
                    <span>mariana@amoretti.mx</span>
                    <span>+52 444 000 0000</span>
                </div>
            </div>

            {{-- Redes --}}
            <div>
                <h3 class="amo-footer-title">Síguenos</h3>

                <p style="font-size:14px;color:rgba(255,255,255,0.68);line-height:1.7;margin-bottom:16px;">
                    Descubre nuevas colecciones, temporadas y celebraciones especiales.
                </p>

                <div class="amo-socials">
                    <a href="#" class="amo-social">
                        <span class="material-symbols-outlined">photo_camera</span>
                    </a>
                    <a href="#" class="amo-social">
                        <span class="material-symbols-outlined">smart_display</span>
                    </a>
                    <a href="#" class="amo-social">
                        <span class="material-symbols-outlined">alternate_email</span>
                    </a>
                    <a href="#" class="amo-social">
                        <span class="material-symbols-outlined">favorite</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="amo-footer-bottom">
            <div class="amo-footer-copy">
                © {{ date('Y') }} Amoretti · Pastelería artesanal
            </div>
            <div class="amo-footer-note">
                <span class="material-symbols-outlined">verified</span>
                Hecho con dedicación para cada celebración
            </div>
        </div>
    </div>
</footer>