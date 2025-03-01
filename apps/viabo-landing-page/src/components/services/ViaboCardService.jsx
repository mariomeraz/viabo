import { imagesPath } from "../../constants/constants"

export const ViaboCardService = ({ isDesktop = false }) => {
	const content = (
		<div className={"flex  flex-col gap-8  text-gray-200"}>
			<p className={"text-xl "}>Tarjetas de crédito Viabo Pay para tu empresa (Mastercard).</p>

			<p className={"text-xl"}>
				Controla con seguridad los gastos y viáticos. Al tener el control e históricos de consumo,
				podrás agregar beneficios de cashback, programas de fidelización y/o beneficios a la medida.
			</p>

			<div className={"m-auto block px-10 pb-10"}>
				<img
					loading="lazy"
					className={"h-auto w-auto"}
					src={`${imagesPath}/viabo-card-service.webp`}
					alt={"tipos de tarjetas de pago"}
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
