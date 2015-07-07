//
//  SelectNowViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SelectNowViewController : UIViewController <UIAlertViewDelegate>
@property (weak, nonatomic) IBOutlet UILabel *header;
@property (weak, nonatomic) IBOutlet UIView *countdownView;
@property (weak, nonatomic) IBOutlet UILabel *countdownLabel;

@property (weak, nonatomic) IBOutlet UIView *firstChoiceView;
@property (weak, nonatomic) IBOutlet UIView *secondChoiceView;
@property (weak, nonatomic) IBOutlet UIView *thirdChoiceView;
@property (weak, nonatomic) IBOutlet UIView *fourthChoiceView;
@property (weak, nonatomic) IBOutlet UIView *fifthChoiceView;

- (IBAction)selectRecipient:(id)sender;

@end
