import { imagesPath } from "@/constants/constants"

export const ViaboPayService = ({ isDesktop = false }) => {
	const content = (
		<div className={"flex  flex-col gap-8  text-gray-200"}>
			<p className={"text-xl "}>
				Acepta pagos con tarjeta de múltiples bancos con tasa preferencial según tipo de comercio:
			</p>
			<img
				loading="lazy"
				className={"w-96"}
				src={`${imagesPath}/payment-types.webp`}
				alt={"tipos de procesadores de pago"}
			/>
			<p className={"text-xl"}>
				Controla uno o varios puntos de cobro (hasta 500 puntos) aplica para términales físicas o
				digitales.
			</p>
			<p className={"text-xl "}>
				Conoce nuestras políticas de liquidación ágil y seguro, ya sea inmediáto y/o máximo 48 hrs.
			</p>
			<div className={"m-auto block px-10 pb-10"}>
				<img
					loading="lazy"
					className={"h-auto w-auto max-w-56"}
					src={`${imagesPath}/viabo-pay-service.webp`}
					alt={"tipos de procesadores de pago"}
				/>
			</div>
		</div>
	)
	if (isDesktop) {
		return (
			<div
				className={
					"mt-4 animate-fade-in-right rounded-lg bg-[#39316b] px-4 py-8 animate-delay-200 "
				}
			>
				{content}
			</div>
		)
	}
	return content
}
