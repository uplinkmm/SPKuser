export function checkNumber(text) {
    return text.replace(/[^0-9]/g, "");
}
// API Configuration
const envBuffaloProviderId = Number.parseInt(
    import.meta.env.VITE_BUFFALO_PROVIDER_ID ?? "",
    10
);

const envBuffaloGameId = Number.parseInt(
    import.meta.env.VITE_BUFFALO_GAME_ID ?? "",
    10
);

export const BUFFALO_API_CONFIG = {
    // Update this to your API base URL
    BASE_URL: "https://moneyking77.online/api",

    // Buffalo Game Provider ID (update if different)
    BUFFALO_PROVIDER_ID: envBuffaloProviderId,
    BUFFALO_TYPE_ID: 1, // Game type ID
};
export const BUFFALO_GAME_ID = envBuffaloGameId; // Game ID
export const BUFFALO_PROVIDER_ID = envBuffaloProviderId; // Game ID
export const BUFFALO_TYPE_ID = 1; // Game ID
// Room Configuration (matches backend)
export const ROOM_CONFIG = [
    {
        room_id: 1,
        min_bet: 50,
        name: "50 အခန်း",
        level: "Low",
        icon: "🎰",
        color: "low",
        image: "50-200x200.png",
    },
    {
        room_id: 2,
        min_bet: 500,
        name: "500 အခန်း",
        level: "Medium",
        icon: "🎲",
        color: "medium",
        image: "500-200x200.png",
    },
    {
        room_id: 3,
        min_bet: 5000,
        name: "5000 အခန်း",
        level: "High",
        icon: "💎",
        color: "high",
        image: "5000-200x200.png",
    },
    {
        room_id: 4,
        min_bet: 10000,
        name: "10000 အခန်း",
        level: "VIP",
        icon: "👑",
        color: "vip",
        image: "10000-200x200.png",
    },
];

// Storage Keys
const STORAGE_KEYS = {
    TOKEN: "buffalo_token",
    USER: "buffalo_user",
    SELECTED_ROOM: "buffalo_selected_room",
};

// Helper function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat("en-US", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    }).format(amount);
}
