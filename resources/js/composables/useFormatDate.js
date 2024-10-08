
export const useFormatDate = () => {
    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const now = new Date();

        // Check if the date is valid
        if (isNaN(date.getTime())) {
            return "Invalid Date";
        }

        // Check if the date is today
        if (date.toDateString() === now.toDateString()) {
            const timeOptions = {
                hour: "2-digit",
                minute: "2-digit",
            };
            return `<span style="border-left:2px solid green; display:block; padding-left:5px;">Today at ${date.toLocaleTimeString("en-US", timeOptions)}</span>`;
        }

        // Format the date
        const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        };

        return date.toLocaleString("en-US", options);
    }

    return { formatDate }
}