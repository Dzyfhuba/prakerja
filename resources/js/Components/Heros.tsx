import Image from '@/Components/Image'
import { formatCurrency } from '@/Helpers'
import Product from '@/types/product'
import { Link } from '@inertiajs/react'
import Markdown from 'react-markdown'
import 'swiper/css'
import 'swiper/css/pagination'
import { Autoplay, Pagination } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/react'

type Props = {
  products: Product[]
}

const Heros = (props: Props) => {
  return (
    <Swiper
      className='h-screen'
      modules={[Pagination, Autoplay]}
      loop={true}
      pagination={{
        clickable: true,
      }}
      autoplay={{
        delay: 2500,
        disableOnInteraction: false,
      }}
    >
      {props.products.map(item => (
        <SwiperSlide key={item.id} className='bg-base-300 !flex flex-col items-center pt-20 pb-16'>
          <div className='w-[90%] h-1/2'>
            <Image
              src={item.images![0]}
              alt={item.name}
              className='h-full w-full max-w-screen-md object-contain mx-auto'
            />
          </div>
          <Link href={`/products/${item.slug}`} className='link-hover px-3'>
            <h2 className='font-bold text-2xl'>
              {item.name}
            </h2></Link>
          <span>{formatCurrency(item.price || 0)}</span>
          <div className='line-clamp-4 p-3 w-full max-w-screen-sm text-sm'>
            <Markdown>{item.description}</Markdown>
          </div>
          <Link href={`/products/${item.slug}`} className='mt-auto btn btn-primary'>
            Show Product
          </Link>
        </SwiperSlide>
      ))}
    </Swiper>
  )
}

export default Heros
