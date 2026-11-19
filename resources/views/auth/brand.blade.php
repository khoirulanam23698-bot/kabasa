<!-- KIRI: tulisan Kabasa Parkir mengambang -->
<style>
  @keyframes brandFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-22px) rotate(-1.2deg); }
  }
  @keyframes brandShadow {
    0%, 100% { transform: scaleX(1); opacity: .35; }
    50% { transform: scaleX(.7); opacity: .15; }
  }
  @keyframes brandGlow {
    0%, 100% { text-shadow: 0 0 30px rgba(14,165,233,.35), 0 12px 40px rgba(37,99,235,.30); }
    50% { text-shadow: 0 0 55px rgba(14,165,233,.65), 0 12px 50px rgba(37,99,235,.50); }
  }
  .brand-float { animation: brandFloat 6s ease-in-out infinite; text-align: center; user-select: none; }
  .brand-kabasa {
    display: block; color: #fff; font-weight: 900; line-height: 1; letter-spacing: -0.04em;
    font-size: clamp(64px, 9vw, 130px);
    animation: brandGlow 6s ease-in-out infinite;
  }
  .brand-parkir {
    display: block; margin-top: 10px; font-weight: 300; text-transform: uppercase;
    letter-spacing: .55em; padding-left: .55em;
    font-size: clamp(22px, 3vw, 42px);
    background: linear-gradient(90deg, #38bdf8, #2563eb);
    -webkit-background-clip: text; background-clip: text; color: transparent;
  }
  .brand-shadow {
    width: 60%; height: 14px; margin: 38px auto 0; border-radius: 50%;
    background: radial-gradient(ellipse at center, rgba(14,165,233,.5), transparent 70%);
    animation: brandShadow 6s ease-in-out infinite;
  }
  @media (prefers-reduced-motion: reduce) {
    .brand-float, .brand-kabasa, .brand-shadow { animation: none; }
  }
</style>

<div class="hidden lg:flex items-center justify-center">
    <div>
        <div class="brand-float">
            <span class="brand-kabasa">Kabasa</span>
            <span class="brand-parkir">Parkir</span>
        </div>
        <div class="brand-shadow"></div>
    </div>
</div>