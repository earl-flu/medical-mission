export function useAgeCalculator() {
    // Function to calculate age
    const calculateAge = (birthdate) => {
        if (birthdate) {
            const today = new Date();
            const birthDate = new Date(birthdate);
            let ageInYears = today.getFullYear() - birthDate.getFullYear();

            const birthMonth = birthDate.getMonth();
            const birthDay = birthDate.getDate();
            const todayMonth = today.getMonth();
            const todayDay = today.getDate();

            if (
                todayMonth < birthMonth ||
                (todayMonth === birthMonth && todayDay < birthDay)
            ) {
                ageInYears--;
            }

            return ageInYears;
        } else {
            return null;
        }
    };

    return {
        calculateAge,
    };
}