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
import Heros from '@/Components/Heros'

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
      {/* Heros */}
      {props.products?.length ? (
        <Heros products={props.products} />
      ) : <>No Products Available</>}

      {/* All Products By Categories */}
      <section id='categories' className='p-3'>
        <h1 className='text-xl font-bold mb-3'>
          Our products
        </h1>
        <div className="flex flex-col gap-3">
          {props.categories?.length ?
            props.categories.map(c => (
              <div className="collapse collapse-arrow bg-base-200" key={c.id}>
                <input type="checkbox" />
                <h2 className="collapse-title text-xl font-bold">
                  {c.name}
                </h2>
                <div className="collapse-content flex-col flex gap-3">
                  {c.products?.length ?
                    c.products.map(p => (
                      <div className='bg-base-300 p-3 rounded-xl'>
                        <h3 className='font-semibold underline text-lg'>
                          {p.name}
                        </h3>
                        <div className='line-clamp-2 text-xs'>
                          <Markdown>
                            {p.description}
                          </Markdown>
                        </div>
                      </div>
                    ))
                    : <>No Products Available in This Category</>}
                </div>
              </div>
            ))
            : <>No Categories Available</>}
        </div>
      </section>
    </Main>
  )
}


export default Dashboard
