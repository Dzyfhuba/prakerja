import { assetUrl } from '@/Helpers'
import { createRef, useEffect, useState } from 'react'
import { TransformComponent, TransformWrapper } from 'react-zoom-pan-pinch'
import styles from './Image.module.css'
import { Dialog, Transition } from '@headlessui/react'
import { Fragment, PropsWithChildren } from 'react'
import { MdClose, MdDownload } from 'react-icons/md'

interface Props extends React.ImgHTMLAttributes<HTMLImageElement> { }

const Modal = ({
  children,
  show = false,
  maxWidth = '2xl',
  closeable = true,
  onClose = () => {},
  className,
}: PropsWithChildren<{
    show: boolean;
    maxWidth?: 'sm' | 'md' | 'lg' | 'xl' | '2xl';
    closeable?: boolean;
    onClose: CallableFunction;
    className?: string;
    zoomable?: boolean;
}>) => {

  useEffect(() => {
    // escape to close
    const escape = (e: KeyboardEvent) => {
      if (e.key === 'Escape') {
        onClose()
      }
    }
    document.addEventListener('keydown', escape)

    return () => {
      document.removeEventListener('keydown', escape)
    }
  }, [show])

  const close = () => {
    if (closeable) {
      onClose()
    }
  }

  const maxWidthClass = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
  }[maxWidth]

  return (
    <Transition show={show} as={Fragment} leave="duration-200">
      <Dialog
        as="div"
        id="modal"
        className="fixed inset-0 flex overflow-y-auto px-4 sm:px-0 items-center z-[9999] transform transition-all"
        onClose={close}
      >
        <Transition.Child
          as={Fragment}
          enter="ease-out duration-300"
          enterFrom="opacity-0"
          enterTo="opacity-100"
          leave="ease-in duration-200"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
        >
          <div className="absolute inset-0 bg-black/50 dark:bg-black/50" />
        </Transition.Child>

        <Transition.Child
          as={Fragment}
          enter="ease-out duration-300"
          enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enterTo="opacity-100 translate-y-0 sm:scale-100"
          leave="ease-in duration-200"
          leaveFrom="opacity-100 translate-y-0 sm:scale-100"
          leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <Dialog.Panel
            className={`flex justify-center items-center
            bg-transparent rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto h-full max-h-full ${maxWidthClass} ${className}`}
            // onClick={(e) => {
            //   e.stopPropagation()
            //   if (closeable) {
            //     onClose()
            //   }
            // }}
          >
            {children}
          </Dialog.Panel>
        </Transition.Child>
      </Dialog>
    </Transition>
  )
}


const Image = ({ className, ...props }: Props) => {
  const [src, setSrc] = useState(props.src)
  const [show, setShow] = useState(false)
  const [error, setError] = useState(false)
  const imageRef = createRef<HTMLImageElement>()

  useEffect(() => {
    setSrc(props.src)

    return () => {
      setSrc(undefined)
    }
  }, [props.src])

  return (
    <>
      <Modal
        onClose={() => {
          console.log('close')
          setShow(false)
        }}
        show={show}
        closeable
        className='!w-full !max-w-none'
        zoomable
      >
        <button
          className='btn btn-square btn-ghost fixed top-4 right-4 z-[9999]'
          onClick={() => {
            setShow(false)
          }}
        >
          <MdClose size={24} />
        </button>
        {/* download button on bottom of screen with fixed position */}
        <a
          href={src}
          download
          className='btn btn-ghost fixed bottom-4 right-4 z-[9999]'
          onClick={e => {
            e.stopPropagation()
          }}
        >
          <MdDownload size={24} />
        </a>
        <TransformWrapper
          onTransformed={(e) => {
            // if full scrolled down, close modal
            if (e.state.positionY === 100){
              setShow(false)
            }
          }}
        >
          <TransformComponent
            contentClass='object-container !w-full !h-full'
            wrapperClass='!mx-auto object-contain !h-auto !w-full object'
            contentProps={{
              onClick: (e) => {
                e.stopPropagation()
                console.log(e)

                // get image element
                const image = e.currentTarget.querySelector('img')

                // if user click outside image bounds, close modal
                const { x, y, width, height } = image!.getBoundingClientRect()
                if (e.clientX < x || e.clientX > x + width || e.clientY < y || e.clientY > y + height) {
                  setShow(false)
                }
              }
            }}
          >
            <img
              onClick={(e) => {
                e.preventDefault()
                console.log('click img zoom')
              }}
              src={src}
              className='h-full w-auto max-h-screen mx-auto hover:cursor-pointer'
            />
          </TransformComponent>
        </TransformWrapper>
      </Modal>
      <img
        ref={imageRef}
        onClick={(e) => {
          if (error) return
          props.onClick && props.onClick(e)
          setShow(true)
        }}
        src={src}
        className={styles.image + (className ? ` ${className}` : '')}
        onError={() => {
          setError(true)
          setSrc(assetUrl('/images/image-not-found.png'))
        }}
      />
    </>
  )
}

export default Image
