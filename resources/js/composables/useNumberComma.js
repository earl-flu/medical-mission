
export const useNumberComma = () => {

    const numberComma = (value) => {
        const formatter = new Intl.NumberFormat('en-US');
        const formattedNumber = formatter.format(value);

        return formattedNumber;
    }

    return { numberComma }
}