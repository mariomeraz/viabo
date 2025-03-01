import { useContext } from "preact/hooks"
import { AccordionContext } from "../Accordion"
import { services } from "./AccordionServices"

const ServicesDetailsDesktop = () => {
	const { selected } = useContext(AccordionContext)
	const element = services?.find((service) => service?.value === selected)

	const Component = element?.component

	if (element) {
		return (
			<div className={" h-auto min-h-screen "}>
				<Component isDesktop />
			</div>
		)
	}
	return null
}

export default ServicesDetailsDesktop
