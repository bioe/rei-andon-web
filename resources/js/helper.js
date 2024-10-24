//Add all your global function over here

export function formatDate(value) {
    if (value) {
        const date = new Date(value);
        return date.toLocaleString();
    }
}

export function formatTimeOnly(value) {
    if (value) {
        const date = new Date(value);
        return date.toLocaleTimeString();
    }
}