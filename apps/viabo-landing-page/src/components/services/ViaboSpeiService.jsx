import { imagesPath } from "@/constants/constants"

export const ViaboSpeiService = ({ isDesktop = false }) => {
	const content = (
		<div className={"flex  flex-col gap-8  text-gray-200"}>
			<p className={"text-xl "}>
				Realiza transferencias entre empresas, a terceros e incluso a tus tarjetas Viabo Mastercard.
			</p>

			<p className={"text-xl font-semibold"}>24/7 los 365 días del año.</p>

			<div className={"m-auto block px-10 pb-10"}>
				<img
					loading="lazy"
					className={"h-auto w-auto"}
					src={`${imagesPath}/viabo-spei-service.webp`}
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
