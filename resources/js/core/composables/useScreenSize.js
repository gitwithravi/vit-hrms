import { ref, watchEffect } from "vue"

const sizeConfig = {
    small: 768,
    medium: 992,
    large: 1200,
    extraLarge: 1440,
}

export function useScreenSize() {
    const screenSize = ref({
        small: window.innerWidth <= sizeConfig.small,
        medium:
            window.innerWidth > sizeConfig.small &&
            window.innerWidth <= sizeConfig.medium,
        large:
            window.innerWidth > sizeConfig.medium &&
            window.innerWidth <= sizeConfig.large,
        extraLarge: window.innerWidth > sizeConfig.large,
    })

    const updateScreenSize = () => {
        const width = window.innerWidth
        screenSize.value = {
            small: width <= sizeConfig.small,
            medium: width > sizeConfig.small && width <= sizeConfig.medium,
            large: width > sizeConfig.medium && width <= sizeConfig.large,
            extraLarge: width > sizeConfig.large,
        }
    }

    // Listen for window resize events
    watchEffect(() => {
        window.addEventListener("resize", updateScreenSize)
        updateScreenSize()

        // Clean up the event listener when the component unmounts
        return () => {
            window.removeEventListener("resize", updateScreenSize)
        }
    })

    return { screenSize }
}
