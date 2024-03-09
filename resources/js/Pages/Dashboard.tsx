import Main from '@/Layouts/Main'
import { PageProps, User } from '@/types'
import Category from '@/types/category'
import Product from '@/types/product'
import { Link } from '@inertiajs/react'
import { Swiper, SwiperSlide } from 'swiper/react'
import NoImage from '@/Images/no-image.png'
import 'swiper/css';
import 'swiper/css/pagination';
import { useEffect, useState } from 'react'
import EasyMDE from 'easymde'
import Markdown from 'react-markdown'
import { formatCurrency } from '@/Helpers'
import Image from '@/Components/Image'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'

interface Props extends PageProps {
  posts?: {
    id?: number
    title?: string
    slug?: string
    content?: string
    user_id?: number
    user?: User
    created_at?: string
    updated_at?: string
  }[]
  categories?: (Category & {
    products?: Product[]
  })[]
  products?: Product[]
}

const Dashboard = (props: Props) => {
  // const [products, setProducts] = useState<Product[]>([])

  // useEffect(() => {
  //   const prods = props.products?.map(item => {
  //     const easyMDE = new EasyMDE()
  //   })
  // }, [])

  return (
    <Main user={props.auth.user}>
      <section>
        {props.products?.length ? (
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
              <SwiperSlide key={item.id} className='bg-base-300 !flex flex-col items-center pt-20 px-3 pb-16'>
                <Image
                  src={item.images![0]}
                  alt={item.name}
                  className='h-1/2 w-1/2 object-contain'
                />
                <h2 className='font-bold text-xl'>
                  {item.name}
                </h2>
                <span>{formatCurrency(item.price || 0)}</span>
                <div className='line-clamp-4'>
                  <Markdown>{item.description}</Markdown>
                </div>
                <Link href={`/posts/${item.slug}`} className='mt-auto btn btn-primary'>
                  Show More
                </Link>
              </SwiperSlide>
            ))}
          </Swiper>
        ) : <>No Products Available</>}
      </section>
    </Main>
  )
}


export default Dashboard
