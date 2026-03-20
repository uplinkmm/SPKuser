const PROVIDER_IMAGE_MAP = {
    cq9: "/providers/slots/cq9.png",
    playstar: "/providers/slots/playstar.png",
    mrslotty: "/providers/slots/mrslotty.png",
    bgaming: "/providers/slots/bgaming.png",
    voltentertainment: "/providers/slots/volt-entertainment.png",
    fazi: "/providers/slots/fazi.png",
    netgame: "/providers/slots/netgame.png",
    netgameentertainment: "/providers/slots/netgame.png",
    kiron: "/providers/slots/kiron.png",
    redrake: "/providers/slots/redrake.webp",
    redrakegaming: "/providers/slots/redrake.webp",
    booongo: "/providers/slots/booongo.png",
    funtagaming: "/providers/slots/funtagaming.png",
    felix: "/providers/slots/felix.png",
    felixgaming: "/providers/slots/felix.png",
    zeusplay: "/providers/slots/zeusplay.png",
    wowgaming: "/providers/slots/wow-gaming.png",
    pragmaticplay: "/providers/slots/pragmatic-play.png",
    jilitcg: "/providers/slots/jili-tcg.png",
    jili: "/providers/slots/jili-tcg.png",
    live22: "/providers/slots/live22.png",
    jdb: "/providers/slots/jdb.png",
    hacksaw: "/providers/slots/hacksaw.png",
    hacksawgaming: "/providers/slots/hacksaw.png",
    bigpot: "/providers/slots/bigpot.png",
    bigpotgaming: "/providers/slots/bigpot.png",
    rich88: "/providers/slots/rich88.png",
    fachai: "/providers/slots/fachai.png",
    pgsoft: "/providers/slots/pg-soft.png",
    pocketgamesoft: "/providers/slots/pg-soft.png",
    pascalgaming: "/providers/slots/pascal-gaming.png",
    epicwin: "/providers/slots/epicwin.png",
    novomatic: "/providers/slots/novomatic.png",
    octoplay: "/providers/slots/octoplay.png",
    boominggames: "/providers/slots/booming-games.png",
    amigogaming: "/providers/slots/amigo-gaming.png",
    habanero: "/providers/slots/habanero.png",
    playace: "/providers/slots/playace.svg",
    spadegaming: "/providers/slots/spade-gaming.png",
    advantplay: "/providers/slots/advantplay.png",
    joker: "/providers/slots/joker.png",
    wmcasino: "/providers/slots/wm-casino.png",
    sexygaming: "/providers/slots/sexy-gaming.png",
    aesexy: "/providers/slots/sexy-gaming.png",
    ailivecasino: "/providers/slots/ai-live-casino.png",
    yeebet: "/providers/slots/yeebet.png",
    yeebetgaming: "/providers/slots/yeebet.png",
    dreamgaming: "/providers/slots/dreamgaming.png",
    worldentertainment: "/providers/slots/world-entertainment.png",
    sagaming: "/providers/slots/sa-gaming.png",
    king855: "/providers/slots/ct855.png",
    ct855: "/providers/slots/ct855.png",
    king855ct855: "/providers/slots/ct855.png",
    fbgames: "/providers/slots/fb-games.png",
    prettygaming: "/providers/slots/pretty-gaming.png",
    astar: "/providers/slots/astar.png",
    allbet: "/providers/slots/allbet.png",
    sbo: "/providers/slots/sbo.png",
    sbobet: "/providers/slots/sbo.png",
};

function normalizeProviderImageKey(value) {
    return String(value || "")
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "");
}

export function getProviderLocalImage(product) {
    const candidates = [product?.name, product?.code];
    for (const candidate of candidates) {
        const key = normalizeProviderImageKey(candidate);
        if (PROVIDER_IMAGE_MAP[key]) {
            return PROVIDER_IMAGE_MAP[key];
        }
    }
    return "/icons/provider_cover.png";
}

export function providerLogoNeedsDarkBackground(product) {
    return getProviderLocalImage(product) === "/providers/slots/kiron.png";
}
